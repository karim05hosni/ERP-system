<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippedOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    // relation with Order
    public function Order(){
        return $this->belongsTo(Order::class);
    }

}
