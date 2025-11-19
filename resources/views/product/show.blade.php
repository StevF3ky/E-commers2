<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- 1. WAJIB ADA: Token CSRF untuk keamanan request AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $product->name }} - Detail Produk</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>

    <link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <a href="{{ route('Home') }}" class="back-btn">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </a>
            <span class="page-title">Home Page</span>
        </div> 
    </nav>

    <div class="main-container">
        
        <div class="image-section">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="main-image">
            @else
                <div style="font-size: 100px; text-align: center;">📦</div>
            @endif
        </div>

        <div class="info-section">
            <span style="font-weight: 500;">{{ Auth::user()->name }}</span>
            
            <h1 class="product-title">{{ $product->name }}</h1>
            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            <div class="divider"></div>

            <span class="section-label">Deskripsi</span>
            <p class="description-text">
                {!! nl2br(e($product->description ?? 'Tidak ada deskripsi.')) !!}
            </p>

            <span class="section-label">Jumlah & Stok</span>
            <div style="display: flex; align-items: center; margin-bottom: 30px;">
                <div class="qty-control">
                    <button class="qty-btn" id="btnMinus"><ion-icon name="remove-outline"></ion-icon></button>
                    
                    {{-- Input qty dengan data stok maksimal --}}
                    <input type="number" value="1" class="qty-input" id="qtyInput" readonly data-max-stock="{{ $product->stock }}">
                    
                    <button class="qty-btn" id="btnPlus"><ion-icon name="add-outline"></ion-icon></button>
                </div>
                <span class="stock-info">Tersisa: <b>{{ $product->stock }}</b> unit</span>
            </div>

            <div class="action-buttons">  
                {{-- 3. WAJIB ADA: data-product-id agar JS tahu produk mana yang diambil --}}
                <button class="btn btn-primary" onclick="addToCart()" data-product-id="{{ $product->product_id }}">
                    <ion-icon name="cart"></ion-icon> Tambah Keranjang
                </button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast">
        <ion-icon name="checkmark-circle" style="color: #10b981; font-size: 20px;"></ion-icon>
        <span>Berhasil masuk keranjang!</span>
    </div>

    <script src="{{ asset('js/product-detail.js') }}"></script>
</body>
</html>