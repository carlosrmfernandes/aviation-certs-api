<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'formNumber',
        'formTrackingNumber',
        'organizationName',
        'organizationAddress',
        'workOrderContractInvoiceNumber',
        'approvingAuthority',
        'approvingCountry',
        'remarks',
        'conformityApprovedDesign',
        'conformityNonApprovedDesign',
        'returnToService',
        'otherRegulation',
        'authorizedSignature13',
        'approvalAuthorizationNo',
        'authorizedSignature14',
        'approvalCertificateNo',
        'name13',
        'date13',
        'name14',
        'date14',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CertificateItem::class);
    }
}
