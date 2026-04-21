<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Jurnal;

class JenisJurnal extends Model
{
    protected $table = 'jenis_jurnal';

    protected $primaryKey = 'idjenis';

    public const CREATED_AT = null;

    public const UPDATED_AT = null;

    protected $fillable = [
        'nm_jurnal',
        'tipe',
        'created_by',
        'update_at',
    ];

    protected function casts(): array
    {
        return [
            'created_by' => 'datetime',
            'tipe' => 'integer',
        ];
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'update_at');
    }

    public function jurnal(): HasMany
    {
        return $this->hasMany(Jurnal::class, 'idjenis', 'idjenis');
    }
}