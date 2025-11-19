<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class ProductController extends Controller
{
    public function index()
    {
        // 1. Ambil data dari Database
        $products = Product::with('category')->latest()->get();
        $categories = Category::all();

        // 2. LAKUKAN PERHITUNGAN (Ini yang hilang sebelumnya)
        $totalProducts = $products->count(); // Menghitung jumlah produk
        $totalStock = $products->sum('stock'); // Menjumlahkan total stok

        // 3. Kirim variabel hasil hitungan ke View
        // Perhatikan bagian 'compact', pastikan ejaannya sama persis
        return view('seller.sellerdashboard', compact('products', 'categories', 'totalProducts', 'totalStock'));
    }

    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required',
            'image' => 'nullable|image|max:2048', 
        ]);

        // Proses Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Simpan ke Database
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Produk dihapus.');
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'category_id' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        // Ambil semua data input
        $data = $request->except(['image']);

        // Cek jika ada gambar baru diupload
        if ($request->hasFile('image')) {
            // (Opsional: Hapus gambar lama disini jika perlu)
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
    }



}