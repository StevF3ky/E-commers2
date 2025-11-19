<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';
    protected $fillable = ['user_id'];

    // Relasi: Satu keranjang punya banyak item
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'cart_id');
    }

    // Relasi: Keranjang milik user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}