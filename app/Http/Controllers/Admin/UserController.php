<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    
    public function index()
    {

        $users = User::where('role', '!=', User::ROLE_ADMIN)->get();
        
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        
        if ($user->isAdmin()) {
            return Redirect::back()->with('error', 'Tidak dapat mengubah peran Admin.');
        }

        $validated = $request->validate([
            'role' => [
                'required', 
                'string', 
                Rule::in([User::ROLE_BUYER, User::ROLE_SELLER]),
            ],
        ]);

        $user->update([
            'role' => $validated['role'],
        ]);

        return Redirect::route('admin.users.index')->with('status', 'Peran pengguna berhasil diperbarui!');
    }
}