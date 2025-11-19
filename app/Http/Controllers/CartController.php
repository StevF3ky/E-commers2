<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Fungsi Tambah ke Keranjang (Dipanggil via AJAX)
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Silakan login terlebih dahulu'], 401);
        }

        $user = Auth::user();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Cek apakah user sudah punya keranjang? Jika belum, buat baru.
        $cart = Cart::firstOrCreate(['user_id' => $user->user_id]);

        // Cek apakah barang ini sudah ada di keranjang?
        $cartItem = CartItem::where('cart_id', $cart->cart_id)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            // Jika sudah ada, update jumlahnya
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Jika belum, buat item baru
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        // Hitung total item di keranjang untuk update badge
        $totalItems = $cart->items()->sum('quantity');

        return response()->json([
            'status' => 'success', 
            'message' => 'Produk berhasil masuk keranjang!',
            'total_items' => $totalItems
        ]);
    }

    // 2. Halaman Checkout / Keranjang
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Cart::where('user_id', Auth::id())->with('items.product.category')->first();
        
        return view('checkout', compact('cart'));
    }

    public function removeItem($id)
    {
        // Cari item berdasarkan ID
        $cartItem = CartItem::where('cart_item_id', $id)->first();

        // Jika ketemu, hapus
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan.');
    }
}