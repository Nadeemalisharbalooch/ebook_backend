<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Events\Auth\CodeVerificationEvent;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
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
 * @method bool isAdmin()
 * @method bool isUser()
 */
#[ObservedBy(UserObserver::class)]
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
        'username',
        'email',
        'password',
        'is_admin',
        'is_active',
        'is_suspended',
        'email_verified_at',
        'is_impersonating',
        'first_name',
        'last_name',
        'is_accept_terms',
        'role',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Cast the 'email_verified_at' to a datetime object.
        'email_verified_at' => 'datetime',

        'is_accept_terms' => 'boolean',

        // Hash the 'password' attribute.
        'password' => 'hashed',

        // Cast 'is_active', 'is_suspended' and 'is_admin' to booleans.
        'is_active' => 'boolean',
        'is_suspended' => 'boolean',
        'is_admin' => 'boolean',
        'is_impersonating' => 'boolean',
    ];

    /**
     * Default attributes for the user model.
     *
     * The following attributes are set as default values for the user model. These
     * values are used when a new user is created and the attributes are not provided.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_locked' => false,
        'is_admin' => false,
        'is_active' => false,
        'is_suspended' => false,
    ];

    /**
     * Check the user's status for login validation.
     *
     * @return string|null Returns error message if status invalid, null if valid.
     */
    public function checkStatus(): ?string
    {
        if (! $this->email_verified_at) {

            event(new CodeVerificationEvent($this));

            return 'Your account is not verified';
        }

        if (! $this->is_active) {
            return 'Your account is not active';
        }

        if ($this->is_suspended) {
            return 'Your account is suspended';
        }
        if ($this->is_locked) {
            return 'Your account is locked';
        }

        return null;
    }

    /**
     * Determine if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin == 1;
    }

    /**
     * Determine if the user is a user/client.
     */
    public function isUser(): bool
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
