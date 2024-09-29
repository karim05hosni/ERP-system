<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public $timestamps= false;
    protected $fillable = [
        'name',
    ];
    public function admin(){
        return $this->belongsToMany(
            User::class, //related model
            'admin_permission', //pivot table
            'permission_id', //FK in pivot table of current model
            'admin_id', //FK in pivot table of current model
            'id',  //PK of current model
            'id' //PK of related model
        );
    }
}
