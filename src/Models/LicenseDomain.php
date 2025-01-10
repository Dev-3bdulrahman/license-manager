<?php

namespace Dev3bdulrahman\LicenseManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LicenseDomain extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_id',
        'domain',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }
}