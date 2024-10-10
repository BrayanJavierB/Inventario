<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = ['nombre', 'nit', 'email', 'Telefono'];

    public function buys(){
        return $this->hasMany(Buy::class, 'id');
    }
}
