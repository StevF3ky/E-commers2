<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product

class HomeController extends Controller
{
    // 1. Halaman Utama (Menampilkan semua produk)
    public function index()
    {
        // Ambil produk terbaru, paginate atau get semua
        $products = Product::latest()->get(); 
        
        return view('Home', compact('products'));
    }

    // 2. Halaman Detail Produk (Ketika diklik)
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return view('product.show', compact('product'));
    }
}