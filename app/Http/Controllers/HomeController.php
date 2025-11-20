<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class HomeController extends Controller
{
    
    public function index(Request $request)
    {
        
        $query = Product::latest();

       
        if ($request->filled('search')) {
            $search = $request->input('search');
            
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
        }

        
        $products = $query->get();
        
        return view('Home', compact('products'));
    }

    
    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return view('product.show', compact('product'));
    }
}