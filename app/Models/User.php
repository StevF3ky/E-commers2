<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Definisikan peran sebagai konstanta
    public const ROLE_ADMIN = 'admin';
    public const ROLE_SELLER = 'seller';
    public const ROLE_BUYER = 'buyer';

    // ... (existing properties)

    // Fungsi untuk mengecek apakah pengguna adalah admin
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    // Fungsi untuk mengecek apakah pengguna adalah seller
    public function isSeller(): bool
    {
        return $this->role === self::ROLE_SELLER;
    }
    
    // Fungsi untuk mengecek apakah pengguna adalah buyer
    public function isBuyer(): bool
    {
        return $this->role === self::ROLE_BUYER;
    }

}
