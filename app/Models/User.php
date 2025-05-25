<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method string|null checkStatus()
 * @method \Laravel\Sanctum\NewAccessToken createToken(string $name, array $abilities = [])
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $dates = ['deleted_at'];

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
     * Check the user's status for login validation.
     *
     * @return string|null Returns error message if status invalid, null if valid.
     */
    public function checkStatus(): ?string
    {
        if (! $this->email_verified_at) {
            return 'Your account is not verified';
        }

        if (! $this->is_active) {
            return 'Your account is not active';
        }

        if ($this->is_suspended) {
            return 'Your account is suspended';
        }

        return null;
    }

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
            'is_active' => 'boolean',
            'is_suspended' => 'boolean',
        ];
    }

    /**
     * Determine if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->is_admin == 1;
    }

    /**
     * Determine if the user is a client.
     */
    public function isClient()
    {
        return $this->is_admin == 0;
    }

    /**
     * Get the profile associated with this user.
     *
     * @return HasOne<Profile>
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
}
