<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Sesuaikan dengan primary key di migration Anda
    protected $primaryKey = 'product_id'; 

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
    ];

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}