<?php

namespace App\Models;

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
        'phone_number',
        'full_address',
    ];

    protected $hidden = [
        'password',
    ];

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
}