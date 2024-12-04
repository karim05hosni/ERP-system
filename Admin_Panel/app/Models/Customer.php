<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'preset_id',
    ];

    public function presets(){
        return $this->belongsTo(Preset::class);
    }
}
