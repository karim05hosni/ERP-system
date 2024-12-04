<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';
    protected $guarded = [];
    public function updateQuantitySold($quantitySold)
    {
        // Ensure the warehouse and product relationships are loaded
        if (!$this->warehouse || !$this->product) {
            throw new Exception('Warehouse or Product not associated with this Inventory.');
        }

        // Update or create an entry in the pivot table
        DB::table('order_product')
            ->updateOrInsert(
                [
                    'product_id' => $this->product_id,
                    'warehouse_id' => $this->warehouse_id, // Assuming the pivot table tracks by warehouse
                ],
                [
                    'quantity' => $quantitySold,
                ]
            );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
