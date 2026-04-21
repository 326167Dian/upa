<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kas extends Model
{
    protected $table = 'kas';

    protected $primaryKey = 'id_kas';

    public const CREATED_AT = null;

    public const UPDATED_AT = null;

    protected $fillable = [
        'saldo',
        'created_by',
        'update_at',
    ];

    protected function casts(): array
    {
        return [
            'created_by' => 'datetime',
            'saldo' => 'float',
        ];
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'update_at');
    }
}