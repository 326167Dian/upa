<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'id',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'id');
    }

    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function fotoKegiatan(): HasMany
    {
        return $this->hasMany(FotoKegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }
}