<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificateItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_id',
        'item',
        'description',
        'partNumber',
        'quantity',
        'serialNumber',
        'status'
    ];

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(Certificate::class);
    }
}
