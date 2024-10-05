<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'nit', 'email', 'Telefono'];

    public function buys(){
        return $this->hasMany(Buy::class, 'id');
    }
}
