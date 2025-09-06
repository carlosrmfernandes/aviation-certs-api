<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';

    protected $fillable = [
        'description',
        'partNumber',
        'serialNumber',
        'name',
        'formNumber',
        'workOrderNumber',
        'quantity',
        'status',
        'remarks',
        'approval',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
