<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - {{ config('app.name') }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/Home.css'])
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

    <header class="navbar-fixed">
        <div class="navbar-wrapper" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <div class="navbar-left">
                <a href="{{ route('Home') }}" class="logo" style="text-decoration: none; display: flex; align-items: center; gap: 3px;">
                    <ion-icon name="cart-outline" class="cart-icon"></ion-icon>
                    <h1>Beliin</h1>
                </a>
            </div>
            <div class="navbar-right">
                <a href="{{ route('checkout') }}" style="position: relative; color: #333; font-size: 26px; text-decoration: none; padding-right: 20px; padding-top: 8px;">
                    <ion-icon name="cart-outline"></ion-icon>
                </a>
                <div x-data="{ open: false }" @click.outside="open = false" class="relative profile-dropdown">
                    <button @click="open = ! open" class="profile-icon-btn" style="display: flex; align-items: center;">
                        <ion-icon name="person-circle-outline" class="profile-icon-size"></ion-icon>
                    </button>
                    <div x-show="open" class="dropdown-menu" style="display: none; position: absolute; right: 0; top: 100%; background: white; border: 1px solid #ddd; border-radius: 8px; width: 150px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="dropdown-menu-item">Profile</a>
                            @if (Auth::user()->role === 'seller')
                                <a href="{{ route('seller.dashboard') }}" class="dropdown-menu-item" >Seller Menu</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-menu-item logout-btn">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="profile-container">
        <aside class="card profile-card">
            <div class="avatar-container">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff" alt="Profile" class="avatar-img">
            </div>
            <h2 class="user-name">{{ $user->name }}</h2>
            <p class="user-email">{{ $user->email }}</p>
        </aside>

        <main class="card">
            
            
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">Profil berhasil diperbarui.</div>
            @elseif (session('status') === 'password-updated')
                <div class="alert alert-success">Password berhasil diubah!</div>
            @endif

            
            <form id="profileForm" method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf @method('patch')
                <div class="section-title">
                    <span>Informasi Pribadi</span>
                    <button type="button" class="btn btn-outline view-mode-only" onclick="toggleEditMode(true)">
                        <i class="fas fa-pen"></i> Edit Profil
                    </button>
                </div>
                <div class="info-group">
                    <label>Nama Lengkap</label>
                    <div class="info-value">{{ $user->name }}</div>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                    @error('name') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                <div class="info-group">
                    <label>Alamat Email</label>
                    <div class="info-value">{{ $user->email }}</div>
                    <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                    @error('email') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                <div class="edit-mode-only" style="gap: 1rem; margin-top: 1rem;">
                    <button type="button" class="btn btn-outline" onclick="toggleEditMode(false)">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>

            <hr class="divider">

           
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf @method('put')
                
                <div class="section-title">
                    <span>Ganti Password</span>
                </div>

                
                <div class="info-group">
                    <label>Password Saat Ini</label>
                    <div class="password-wrapper">
                        <input type="password" name="current_password" id="current_password" class="form-input-pass" placeholder="Masukkan password lama">
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('current_password', this)"></i>
                    </div>
                    @if($errors->updatePassword->has('current_password'))
                        <span class="error-text">{{ $errors->updatePassword->first('current_password') }}</span>
                    @endif
                </div>

                
                <div class="info-group">
                    <label>Password Baru</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" class="form-input-pass" placeholder="Minimal 8 karakter">
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password', this)"></i>
                    </div>
                    @if($errors->updatePassword->has('password'))
                        <span class="error-text">{{ $errors->updatePassword->first('password') }}</span>
                    @endif
                </div>

                
                <div class="info-group">
                    <label>Konfirmasi Password Baru</label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input-pass" placeholder="Ulangi password baru">
                        <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)"></i>
                    </div>
                    @if($errors->updatePassword->has('password_confirmation'))
                        <span class="error-text">{{ $errors->updatePassword->first('password_confirmation') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>

            <hr class="divider">

        
            <div class="section-title" style="color: var(--danger);">Delete Account</div>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 15px;">
                Menghapus akun akan menghilangkan semua data secara permanen.
            </p>
            <button onclick="deleteAccount()" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i> Hapus Akun Saya
            </button>
            <form id="deleteAccountForm" method="post" action="{{ route('profile.destroy') }}" style="display: none;">
                @csrf @method('delete')
                <input type="hidden" name="password" value="dummy_bypass">
            </form>
        </main>
    </div>

    <script src="{{ asset('js/profile.js') }}"></script>
</body>
</html>