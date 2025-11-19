<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // 1. Beritahu Laravel nama kolom Primary Key Anda
    // (Karena di database Anda namanya 'category_id', bukan 'id')
    protected $primaryKey = 'category_id';

    // 2. Kolom apa saja yang boleh diisi
    protected $fillable = [
        'name',
    ];

    // 3. (Opsional) Relasi ke Produk
    // "Satu kategori bisa punya banyak produk"
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}