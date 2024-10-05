<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'cedula', 'email', 'telefono'];

    public function sales(){
        return $this->hasMany(Sale::class, 'id');
    }
}
