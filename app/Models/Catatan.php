<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Catatan extends Model
{
    protected $table = 'catatan';

    protected $primaryKey = 'id_catatan';

    protected $fillable = [
        'tgl',
        'shift',
        'petugas',
        'deskripsi',
        'file_path',
        'file_name',
        'attachments',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tgl' => 'date',
            'attachments' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
