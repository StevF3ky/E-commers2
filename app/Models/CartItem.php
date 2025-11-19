<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_item_id';
    
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    // Relasi ke Produk (untuk ambil nama & harga & gambar)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}