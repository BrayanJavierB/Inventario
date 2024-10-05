<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'PrecioCompra', 'PrecioVenta', 'descripcion', 'stock'];

    public function buys(){
        return $this->hasMany(Buy::class, 'id');
    }
}
