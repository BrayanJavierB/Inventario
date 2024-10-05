<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'customer_id', 'cantidad', 'preciounitario', 'preciodeventa', 'soporteventa'];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customers(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }


    protected static function boot()
{
    parent::boot();

   
    static::creating(function ($sale) {
        $product = Product::find($sale->product_id);
        if ($product) {
          
            $sale->preciounitario = $product->PrecioVenta; 
        }
    });

    
    static::created(function ($sale) {
        $product = Product::find($sale->product_id);
        if ($product) {
            
            $product->stock -= $sale->cantidad;
            $product->save(); 
        }
    });

    
    static::deleted(function ($sale) {
        $product = Product::find($sale->product_id);
        if ($product) {
            
            $product->stock += $sale->cantidad;
            $product->save(); 
        }
    });
}
}
