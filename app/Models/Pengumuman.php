<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $primaryKey = 'id_pengumuman';

    protected $fillable = [
        'berita',
        'id_operator',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'id_operator');
    }
}