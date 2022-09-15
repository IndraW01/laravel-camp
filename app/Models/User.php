<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'occupation',
        'is_admin',
        'google_id',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    public function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value)
        );
    }

    // Cek User Google
    public function cekUser($idGoogle)
    {
        return $this->whereGoogleId($idGoogle)->first();
    }

    // Create User Google
    public function createUserGoogle($user)
    {
        $userCreate = $this->create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'avatar' => $user->avatar,
            'google_id' => $user->id,
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

        return $userCreate;
    }

    // User Login
    public function userLogin(): User
    {
        return Auth::user();
    }

    // update User
    public function userUpdate($validateDataUser): User
    {
        $this->userLogin()->update($validateDataUser);

        return $this->userLogin();
    }
}
