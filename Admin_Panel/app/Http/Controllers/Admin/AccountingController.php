<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    //
    public function income_statement()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($currentMonth >= 1 && $currentMonth <= 3) {
            $startDate = $currentYear . '-01-01';
            $endDate = $currentYear . '-03-31';
        } elseif ($currentMonth >= 4 && $currentMonth <= 6) {
            $startDate = $currentYear . '-04-01';
            $endDate = $currentYear . '-06-30';
        } elseif ($currentMonth >= 7 && $currentMonth <= 9) {
            $startDate = $currentYear . '-07-01';
            $endDate = $currentYear . '-09-30';
        } elseif ($currentMonth >= 10 && $currentMonth <= 12) {
            $startDate = $currentYear . '-10-01';
            $endDate = $currentYear . '-12-31';
        }
        // calc inventory before septembre
        $beginningInventory = Purchase::where('purchase_date', '<', $startDate)
            ->selectRaw('SUM(total_cost) as total_value')
            ->value('total_value');
        if ($beginningInventory < 0) {
            $beginningInventory = 0;
        }
        $cost_of_sales = Sale::whereBetween('sale_date', [$startDate, $endDate])
            ->selectRaw('SUM(cost_per_unit*quantity) as total_cost')
            ->value('total_cost');
        $Purchases = Purchase::whereBetween('purchase_date', [$startDate, $endDate])
            ->sum('total_cost');

        $Sales = Sale::whereBetween('sale_date', [$startDate, $endDate])
            ->sum('total_price');
        // Step 3: Calculate Ending Inventory
        $endingInventory = $beginningInventory + $Purchases - $Sales;
        // Step 4: Calculate Gross Profit
        $grossProfit = $Sales - $cost_of_sales;
        $netProfit = Sale::whereBetween('sale_date',[$startDate, $endDate])
        ->selectRaw('SUM((price_per_unit - cost_per_unit) * quantity) AS profit')
        ->value('profit');
        $netProfit -= ($grossProfit*16)/100;
        return view('Admin.accounting.statement', compact([
            'endingInventory',
            'Sales',
            'Purchases',
            'cost_of_sales',
            'beginningInventory',
            'grossProfit',
            'netProfit',
            'startDate',
            'endDate',
        ]));
    }
}
