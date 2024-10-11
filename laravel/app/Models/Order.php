<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public function products(){
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id');
    }
    public function ShippedOrder(){
        return $this->hasOne(ShippedOrder::class, 'order_id', 'id');
    }
}
