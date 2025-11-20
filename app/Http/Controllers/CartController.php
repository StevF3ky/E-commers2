<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
   
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Silakan login terlebih dahulu'], 401);
        }

        $user = Auth::user();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        
        $cart = Cart::firstOrCreate(['user_id' => $user->user_id]);

       
        $cartItem = CartItem::where('cart_id', $cart->cart_id)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            
            CartItem::create([
                'cart_id' => $cart->cart_id,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        
        $totalItems = $cart->items()->sum('quantity');

        return response()->json([
            'status' => 'success', 
            'message' => 'Produk berhasil masuk keranjang!',
            'total_items' => $totalItems
        ]);
    }

    
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
        
        $cartItem = CartItem::where('cart_item_id', $id)->first();

        
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan.');
    }

    public function updateQuantity(Request $request, $id)
    {
    $request->validate([
        'change' => 'required|integer'
    ]);
    $cartItem = CartItem::where('cart_item_id', $id)->first();
    if (!$cartItem) {
        return response()->json(['status' => 'error', 'message' => 'Item tidak ditemukan'], 404);
    }
    $newQuantity = $cartItem->quantity + $request->change;
    if ($newQuantity < 1) {
        return response()->json(['status' => 'error', 'message' => 'Minimal pembelian 1 item']);
    }
    $cartItem->quantity = $newQuantity;
    $cartItem->save(); 
    $lineTotal = $cartItem->quantity * $cartItem->product->price;
    $cart = Cart::with('items.product')->find($cartItem->cart_id);
    $subtotal = 0;
    foreach($cart->items as $item) {
        $subtotal += $item->quantity * $item->product->price;
    }
    return response()->json([
        'status' => 'success',
        'new_quantity' => $newQuantity,
        'new_line_total' => 'Rp ' . number_format($lineTotal, 0, ',', '.'),
        'new_subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.')
    ]);
    }

    
}