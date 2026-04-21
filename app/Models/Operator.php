<?php

namespace App\Models;

use App\Models\Pengumuman;
use App\Support\FeaturePermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operator extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'username',
        'password',
        'role',
        'permissions',
        'phone_number',
        'full_address',
        'avatar_path',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'permissions' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class, 'id', 'id');
    }

    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'id', 'id');
    }

    public function pengumuman(): HasMany
    {
        return $this->hasMany(Pengumuman::class, 'id_operator', 'id');
    }

    public static function featureDefinitions(): array
    {
        return FeaturePermission::definitions();
    }
}