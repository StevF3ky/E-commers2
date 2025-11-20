<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manajemen Pengguna</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/Home.css'])
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        body {
            font-family:  sans-serif;
            background-color: #F4F2EE;
            padding-top: 80px; 
        }
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <header class="navbar-fixed"> 
        <div class="navbar-wrapper" >  
            <div class="navbar-left">
                <a href="{{ route('Home') }}" class="logo">
                    <ion-icon name="cart-outline" class="cart-icon"></ion-icon>
                    <h1>Beliin</h1>
                </a>
            </div>
            
            <div class="navbar-right">
                <div x-data="{ open: false }" @click.outside="open = false" class="relative profile-dropdown">
                    <button @click="open = ! open" class="profile-icon-btn" style="display: flex; align-items: center;">
                        <ion-icon name="person-circle-outline" class="profile-icon-size"></ion-icon>
                    </button>

                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-100" 
                        x-transition:enter-start="transform opacity-0 scale-95" 
                        x-transition:enter-end="transform opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="transform opacity-100 scale-100" 
                        x-transition:leave-end="transform opacity-0 scale-95" 
                        class="dropdown-menu"
                        style="display: none; position: absolute; right: 0; top: 100%; background: white; border: 1px solid #ddd; border-radius: 8px; width: 150px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);" 
                    >
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" class="dropdown-menu-item" >
                                {{ __('Profile') }}
                            </a>
                            
                            <a href="{{ route('admin.users.index') }}" class="dropdown-menu-item">
                                {{ __('User Menu') }}
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-menu-item logout-btn" >
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </header>

   
    <div class="admin-container">  
        <div class="flex justify-between items-center mb-6 mt-4">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
            <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded shadow-sm border">Total Pengguna: {{ $users->count() }}</span>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-6 text-gray-700 border-b pb-2">Daftar Pengguna (Buyer & Seller)</h3>    
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded shadow-sm flex items-center">
                        <ion-icon name="checkmark-circle" class="mr-2 text-xl"></ion-icon>
                        {{ session('status') }}
                    </div>
                @endif
                <div class="overflow-x-auto rounded-lg border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama User</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status Peran</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $roleClass = match($user->role) {
                                                'seller' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                'admin'  => 'bg-gray-800 text-white border-gray-900',
                                                default  => 'bg-green-100 text-green-800 border-green-200',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $roleClass }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if(Auth::id() !== $user->user_id)
                                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                
                                                @if ($user->isBuyer())
                                                    <input type="hidden" name="role" value="{{ App\Models\User::ROLE_SELLER }}">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 text-indigo-600 bg-white hover:bg-indigo-50 rounded-md text-xs font-bold tracking-wide shadow-sm transition ease-in-out duration-150">
                                                        <ion-icon name="briefcase-outline" class="mr-1"></ion-icon> Jadikan Seller
                                                    </button>
                                                @elseif ($user->isSeller())
                                                    <input type="hidden" name="role" value="{{ App\Models\User::ROLE_BUYER }}">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 text-red-600 bg-white hover:bg-red-50 rounded-md text-xs font-bold tracking-wide shadow-sm transition ease-in-out duration-150">
                                                        <ion-icon name="person-outline" class="mr-1"></ion-icon> Jadikan Buyer
                                                    </button>
                                                @endif
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


