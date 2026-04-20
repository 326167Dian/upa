<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';

    protected $primaryKey = 'id_kehadiran';

    public const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'id_kegiatan',
        'waktu',
        'hadir',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'waktu' => 'datetime',
            'hadir' => 'integer',
        ];
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'id');
    }

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }
}