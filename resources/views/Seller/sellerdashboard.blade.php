<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>{{ config('app.name', 'BeliIn') }} E-commerce Final</title>
     
    @vite(['resources/css/Home.css', 'resources/js/app.js', 'resources/css/seller.css', 'resources/js/seller.js'] ) 

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

                <div class="navbar-right">      
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
                                
                                    <a href="{{ route('seller.dashboard') }}" class="dropdown-menu-item">
                                            {{ __('Seller Menu') }}
                                    </a>
                                        
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-menu-item logout-btn">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
        </div>
    </header>

    <main class="main-content">
        <header class="header">
            <div class="title">
                <div class="user-profile">
                <span style="font-weight: 500;">{{ Auth::user()->name }}</span>
                </div>
                <p style="color: var(--text-muted); font-size: 14px;">Kelola produk penjualan Anda</p>
            </div>
           
        </header>

        @if(session('success'))
        <div style="padding: 15px; background-color: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon"><ion-icon name="cube-outline"></ion-icon></div>
                </div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Total Produk</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon"><ion-icon name="layers-outline"></ion-icon></div>
                </div>
                <div class="stat-value">{{ $totalStock }}</div>
                <div class="stat-label">Total Stok</div>
            </div>
        </div>

        <div class="section-header">
            <h2 style="font-size: 18px; font-weight: 600;">Daftar Produk</h2>
            <button class="btn-primary" onclick="openModal()">
                <ion-icon name="add-circle-outline"></ion-icon>Tambah Produk
            </button>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <div class="product-cell">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/100' }}" alt="{{ $product->name }}" class="product-img">
                                <div>
                                    <div style="font-weight: 500;">{{ $product->name }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">ID: #{{ $product->product_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->category->name ?? 'Umum' }}</td>
                        <td class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="stock-badge {{ $product->stock < 5 ? 'stock-low' : '' }}">
                                {{ $product->stock }} Unit
                            </span>
                        </td>
                        <td>
                            <button onclick="editProduct({{json_encode($product) }})" class="action-btn btn-edit" style="color: var(--accent-color); margin-right: 5px;">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>


                            <form action="{{ route('seller.products.destroy', $product->product_id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-delete">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 20px;">tidak ada produk di toko anda.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <div class="modal-overlay" id="productModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Produk Baru</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            
            <form id="productForm" action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-input" placeholder="Nama Produk" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label class="form-label">Harga</label>
                        <input type="number" name="price" class="form-input" placeholder="0" required>
                    </div>
                    <div>
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" class="form-input" placeholder="0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-textarea" placeholder="Deskripsi produk..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Foto Produk</label>
                    <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 24px; color: var(--accent-color); margin-bottom: 8px;"></i>
                        <p style="font-size: 12px; color: var(--text-muted);">Klik untuk upload gambar</p>
                    </div>
                    <input type="file" id="fileInput" name="image" accept="image/*" style="display: none" onchange="previewImage(event)">
                    <img id="imagePreview" class="preview-img">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>