<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\JenisJurnal;

class Jurnal extends Model
{
    protected $table = 'jurnal';

    protected $primaryKey = 'id_jurnal';

    public const CREATED_AT = null;

    public const UPDATED_AT = null;

    protected $fillable = [
        'tanggal',
        'ket',
        'petugas',
        'idjenis',
        'debit',
        'kredit',
        'carabayar',
        'current',
        'created_by',
        'update_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'current' => 'datetime',
            'created_by' => 'datetime',
            'debit' => 'integer',
            'kredit' => 'integer',
        ];
    }

    public function jenisJurnal(): BelongsTo
    {
        return $this->belongsTo(JenisJurnal::class, 'idjenis', 'idjenis');
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'update_at');
    }
}