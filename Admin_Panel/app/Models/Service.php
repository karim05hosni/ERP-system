<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function presets(){
        return $this->belongsToMany(Preset::class);
    }
}
