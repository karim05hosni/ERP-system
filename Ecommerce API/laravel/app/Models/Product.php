<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_product', 'product_id', 'cart_id')->withPivot('quantity');
    }
    public function order(){
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id');
    }

}
