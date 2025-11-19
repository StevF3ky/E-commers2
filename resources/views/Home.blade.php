<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>{{ config('app.name', 'BeliIn') }} E-commerce Final</title>
     
    @vite(['resources/css/Home.css', 'resources/js/app.js']) 

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
</head>
<body>
    <header class="navbar-fixed">
        <div class="navbar-wrapper">   
           <div class="navbar-left">
                <div class="logo">
                    <a href="{{ route('Home') }}" class="logo" style="text-decoration: none; display: flex; align-items: center; gap: 3px; cursor: pointer;">
                    <ion-icon name="cart-outline" class="cart-icon"></ion-icon>
                    <h1>Beliin</h1> 
                    </a>
                </div>
            </div>
            
            <div class="navbar-center">
                <div class="search-bar">
                    <input type="text" placeholder="Cari produk, merek...">
                    <button class="search-btn">
                        <ion-icon name="search-outline"></ion-icon>
                    </button>
                </div>
            </div>

            <div class="navbar-right">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('checkout') }}" style="position: relative; color: #333; font-size: 26px; text-decoration: none; padding-right: 20px; padding-top: 8px;">
                            <ion-icon name="cart-outline"></ion-icon>
                        </a>
                        <div x-data="{ open: false }" @click.outside="open = false" class="relative profile-dropdown">
                            <button @click="open = ! open" class="profile-icon-btn">
                                <ion-icon name="person-circle-outline" class="profile-icon-size"></ion-icon>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-100" 
                                x-transition:enter-start="transform opacity-0 scale-95" 
                                x-transition:enter-end="transform opacity-100 scale-100" 
                                x-transition:leave="transition ease-in duration-75" 
                                x-transition:leave-start="transform opacity-100 scale-100" 
                                x-transition:leave-end="transform opacity-0 scale-95" 
                                class="dropdown-menu"
                                style="display: none;" 
                            >
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="dropdown-menu-item">
                                        {{ __('Profile') }}
                                    </a>
                                    
                                    @if (Auth::user() -> role === 'seller')
                                        <a href="{{ route('seller.dashboard') }}" class="dropdown-menu-item">
                                            {{ __('Seller Menu') }}
                                        </a>
                                        @endif

                                       @if (Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.users.index') }}" class="dropdown-menu-item">
                                            {{ __('User Menu') }}
                                        </a>
                                        @endif 

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-menu-item logout-btn">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>                        
                                </div>
                            </div>
                        </div>
                    @else
                        <nav class="auth-buttons">
                            <a href="{{ route('login') }}" class="login-btn" style="text-decoration:none;">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="register-btn" style="text-decoration:none;">
                                    Daftar
                                </a>
                            @endif
                        </nav>
                    @endauth
                @endif
            </div>    
        </div>
    </header>

    <main class="content-wrapper">
        <section class="banner-section">
            <div class="section-header">
                <h2>Rekomendasi Terbaik Mencari Product</h2>
            </div>
            
            <div class="banners-grid">
                <div class="banner-card main-banner">
                    <div class="banner-content">
                        <h3>Membeli Produk <br> Brand Ternama Hemat!</h3>
                        
                    </div>
                    <div class="banner-image">
                        <span class="icon-placeholder">🖥️</span>
                    </div>
                </div>

                <div class="banner-card promo-banner promo-makanan">
                    <span class="banner-label">MAKANAN</span>
                    <div class="promo-info">
                        <h4>Makanan Ringan & Bahan Pangan Terbaik</h4>
                    </div>
                    <span class="icon-placeholder small-icon">🍎</span>
                </div>

                <div class="banner-card promo-banner promo-belanja">
                    <span class="banner-label">BELANJA</span>
                    <div class="promo-info">
                        <h4>Kebutuhan Sehari-hari & Rumah Tangga</h4>
                    </div>
                    <span class="icon-placeholder small-icon">📦</span>
                </div>
            </div>
        </section>

        <section class="product-section">
            <h2>Produk Beliin</h2>
            <div class="product-grid">
                {{-- Mulai Looping Data Produk dari Database --}}
                @forelse($products as $product)
                    {{-- Bungkus kartu dengan Link ke Halaman Detail --}}
                    <a href="{{ route('product.show', $product->product_id) }}" style="text-decoration: none; color: inherit;">
                        <div class="product-card">
                            
                            {{-- Logika Gambar: Tampilkan foto jika ada, jika tidak pakai icon --}}
                            <div class="product-image-placeholder" style="padding: 0; overflow: hidden; position: relative;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                        alt="{{ $product->name }}" 
                                        style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                @else
                                    <span style="font-size: 40px;">📦</span>
                                @endif
                            </div>

                            {{-- Nama Produk --}}
                            <p class="product-name">{{ $product->name }}</p>

                            {{-- Harga Produk (Format Rupiah: Rp 10.000) --}}
                            <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @empty
                    {{-- Tampilan jika database kosong --}}
                    <div style="grid-column: 1 / -1; text-align: center; padding: 20px; color: #666;">
                        <p>Belum ada produk yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </section>
        
    </main>
</body>
</html>