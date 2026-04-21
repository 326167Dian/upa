<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoKegiatan extends Model
{
    protected $table = 'foto_kegiatan';

    protected $primaryKey = 'id_foto_kegiatan';

    protected $fillable = [
        'id_kegiatan',
        'foto',
        'keterangan',
        'created_by',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'created_by');
    }
}