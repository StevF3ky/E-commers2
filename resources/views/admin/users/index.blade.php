<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Panel: Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Pengguna (Buyer & Seller)</h3>
                    
                    {{-- AREA NOTIFIKASI STATUS & ERROR --}}
                    @if (session('status'))
                        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded font-medium text-sm">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded font-medium text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- TABEL DATA USER --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran Saat Ini</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user) {{-- Melakukan looping (perulangan) pada data $users --}}
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                        
                                        {{-- Penanda Role dengan Warna --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                // Menentukan warna badge berdasarkan role
                                                $roleClass = $user->role == 'seller' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800';
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleClass }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        
                                        {{-- FORMULIR PENGUBAH ROLE (AKSI) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{-- Form ditujukan ke rute admin.users.updateRole dengan method PATCH --}}
                                            <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                
                                                @if ($user->isBuyer())
                                                    {{-- Jika user saat ini BUYER, tampilkan tombol untuk menjadi SELLER --}}
                                                    <input type="hidden" name="role" value="{{ App\Models\User::ROLE_SELLER }}">
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900 bg-transparent border border-indigo-200 hover:border-indigo-400 rounded-md px-3 py-1 text-xs transition duration-150 ease-in-out">Jadikan Seller</button>
                                                @elseif ($user->isSeller())
                                                    {{-- Jika user saat ini SELLER, tampilkan tombol untuk menjadi BUYER --}}
                                                    <input type="hidden" name="role" value="{{ App\Models\User::ROLE_BUYER }}">
                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent border border-red-200 hover:border-red-400 rounded-md px-3 py-1 text-xs transition duration-150 ease-in-out">Jadikan Buyer</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>