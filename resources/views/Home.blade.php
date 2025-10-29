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
                    <ion-icon name="cart-outline" class="cart-icon"></ion-icon>
                    <h1>Beliin</h1>
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

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-menu-item logout-btn">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                    @if (Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.users.index') }}" class="dropdown-menu-item">
                                            {{ __('User Menu') }}
                                        </a>
                                    @endif
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
                {{-- Ini adalah blok yang idealnya diisi dengan loop @foreach ($products as $product) --}}
                <div class="product-card">
                    <div class="product-image-placeholder">💻</div>
                    <p class="product-name">test1</p>
                    <p class="product-price">1891231</p>
                    </div>
                <div class="product-card">
                    <div class="product-image-placeholder">☕</div>
                    <p class="product-name">test2k</p>
                    <p class="product-price">1844123</p>
                    </div>
                <div class="product-card">
                    <div class="product-image-placeholder">👚</div>
                    <p class="product-name">test3</p>
                    <p class="product-price">1841234</p>
                    </div>
                <div class="product-card">
                    <div class="product-image-placeholder">🧴</div>
                    <p class="product-name">kopi</p>
                    <p class="product-price">184123</p>
                    </div>
                <div class="product-card">
                    <div class="product-image-placeholder">💡</div>
                    <p class="product-name">test23544</p>
                    <p class="product-price">184124</p>
                    </div>
                <div class="product-card">
                    <div class="product-image-placeholder">📷</div>
                    <p class="product-name">test56</p>
                    <p class="product-price">Rp. 12300321</p>
                    </div>
                <div class="product-card">
                    <div class="product-image-placeholder">⌚</div>
                    <p class="product-name">test4</p>
                    <p class="product-price">2203123</p>
                    </div>

                <div class="product-card">
                    <div class="product-image-placeholder">🎧</div>
                    <p class="product-name">test7</p>
                    <p class="product-price">95123123</p>
                    </div>
                {{-- Batas blok produk --}}
                </div>
        </section>
        
    </main>
</body>
</html>