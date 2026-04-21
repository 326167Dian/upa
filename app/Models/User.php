<?php

namespace App\Models;

use App\Support\FeaturePermission;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public const ROLE_ADMIN = 'admin';

    public const ROLE_USER = 'user';

    public const ROLE_CUSTOM = 'custom';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'role',
        'permissions',
        'email',
        'password',
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
            'permissions' => 'array',
            'password' => 'hashed',
        ];
    }

    public function operator(): HasOne
    {
        return $this->hasOne(Operator::class);
    }

    public function hasFeatureAccess(string $permission): bool
    {
        if ($this->role === self::ROLE_ADMIN) {
            return true;
        }

        if (! in_array($permission, FeaturePermission::keys(), true)) {
            return false;
        }

        if ($this->role === self::ROLE_USER) {
            return true;
        }

        return FeaturePermission::grants($this->permissions, $permission);
    }

    public function landingRouteName(): string
    {
        foreach (FeaturePermission::definitions() as $permission => $definition) {
            if ($this->hasFeatureAccess(FeaturePermission::permissionKey($permission, 'view'))) {
                return $definition['route'];
            }
        }

        return 'login';
    }
}
