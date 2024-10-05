<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'supplier_id', 'cantidad', 'PrecioUnitario', 'PrecioDeCompra', 'SoporteCompra'];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function suppliers(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }


    protected static function boot()
{
    parent::boot();

    // Este hook es para cuando se está creando una compra
    static::creating(function ($buy) {
        $product = Product::find($buy->product_id);
        if ($product) {
            // Si quieres establecer el precio del producto en la compra, puedes hacerlo aquí
            $buy->PrecioUnitario = $product->PrecioCompra; // Asegúrate de que este campo exista
        }
    });

    // Este hook es para cuando se ha creado una compra (se aumenta el stock)
    static::created(function ($buy) {
        $product = Product::find($buy->product_id);
        if ($product) {
            // Sumar la cantidad comprada al stock
            $product->stock += $buy->cantidad;
            $product->save(); // Guardar el nuevo stock
        }
    });

    // Este hook es para cuando se ha eliminado una compra (se revierte la compra y se resta el stock)
    static::deleted(function ($buy) {
        $product = Product::find($buy->product_id);
        if ($product) {
            // Restar la cantidad que estaba en la compra
            $product->stock -= $buy->cantidad;
            $product->save(); // Guardar el nuevo stock
        }
    });
}
}
