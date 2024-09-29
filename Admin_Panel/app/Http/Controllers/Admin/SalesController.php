<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class SalesController extends Controller
{
    //
    public function index(){

        // Gate::authorize('has-permission',['Sales']);
        $sales_data = Sale::select(
            DB::raw('YEAR(sale_date) as year'),
            DB::raw(' MONTH(sale_date) AS month'),
            DB::raw('SUM(total_price) AS total_sales'),
            DB::raw('SUM((price_per_unit - cost_per_unit) * quantity) AS total_profit'),
        )->groupBy('year','month')->get();
        $currentMonth = date('m');
        $trending_products_data = Sale::select(
            DB::raw('product_id'),
            DB::raw('SUM(quantity) AS total_sold'),
            DB::raw(' MONTH(sale_date) AS month'),
        )
        ->whereMonth('sale_date', $currentMonth)
        ->groupBy('product_id','month')
        ->orderBy('total_sold', 'desc')
        ->take(4)
        ->get();
        foreach ($trending_products_data as $product) {
            # code...
            
            $product->product = Product::select('name_en')->where('id',$product->product_id)->first()->name_en;
        }
            return view('Admin.sales.reports', compact('sales_data','trending_products_data'));
    }
}
