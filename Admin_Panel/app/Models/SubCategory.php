<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'subcategories';
    protected $guarded = [];


    public function products(){
        return $this->hasMany(Product::class, 'subcate_id', 'id');
    }
}
