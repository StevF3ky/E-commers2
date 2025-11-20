<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Beliin</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/checkout.js') }}"></script>
    
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <div class="container">
        <a href="{{ route('Home') }}" style="text-decoration: none; color: #6b7280; display: flex; align-items: center; gap: 5px; margin-bottom: 20px;">
            <i class="fas fa-arrow-left"></i> Home Page
        </a>

        <h1>Keranjang Belanja</h1>

        @if($cart && $cart->items->count() > 0)
            <div class="checkout-grid">
                
                <div class="cart-section">
                    <div class="cart-header">
                        <span>Produk</span>
                        <span>Jumlah</span>
                    </div>

                    <div id="cartItems">
                        @php $subtotal = 0; @endphp

                        @foreach($cart->items as $item)
                            @php 
                                $lineTotal = $item->product->price * $item->quantity; 
                                $subtotal += $lineTotal;
                            @endphp

                            <div class="cart-item">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="item-img" alt="{{ $item->product->name }}">
                                @else
                                    <div class="item-img" style="display: flex; align-items:center; justify-content:center; font-size: 24px;">📦</div>
                                @endif

                                <div class="item-details">
                                    <div class="item-cat">{{ $item->product->category->name ?? 'Umum' }}</div>
                                    <div class="item-title">{{ $item->product->name }}</div>
                                    <div class="item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                                </div>

                                <div class="item-actions">
                                    <div style="font-weight: 600; font-size: 14px; margin-bottom: 10px;" id="line-total-{{ $item->cart_item_id }}">
                                        Rp {{ number_format($lineTotal, 0, ',', '.') }}
                                    </div>

                                    <form action="{{ route('cart.remove', $item->cart_item_id) }}" method="POST" style="display:inline; margin-bottom: 10px;">
                                        @csrf
                                        @method('DELETE') 
                                        <button type="submit" class="remove-btn" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                            <i class="fas fa-trash"></i>Hapus
                                        </button>
                                    </form>

                                    <div class="qty-group" style="margin-top: 10px;">
                                        <button class="qty-btn" onclick="updateQuantity('{{$item->cart_item_id }}', -1)">-</button>
                                        <span class="qty-val" id="qty-val-{{ $item->cart_item_id }}">{{ $item->quantity }}</span>   
                                        <button class="qty-btn" onclick="updateQuantity('{{ $item->cart_item_id }}', 1)">+</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="summary-section">
                    <div class="summary-title">Ringkasan Pesanan</div>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Pajak (0%)</span>
                        <span id="tax">Rp 0</span>
                    </div>

                    <div class="summary-row total">
                        <span>Total</span>
                        <span class="total-price" id="total">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <button class="checkout-btn" onclick="processCheckout()">
                        <i class="fas fa-lock"></i> Bayar Sekarang
                    </button>
                </div>
            </div>
        
        @else
            <div class="cart-section empty-state">
                <div class="empty-icon"><i class="fas fa-shopping-cart"></i></div>
                <h2>Keranjang Anda Kosong</h2>
            </div>
        @endif

    </div>

    
</body>
</html>