<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preset extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function services(){
        return $this->hasMany(Service::class);
    }
    public function threholds(){
        return $this->hasMany(Threshold::class);
    }
}
