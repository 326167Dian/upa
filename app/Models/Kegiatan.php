<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}