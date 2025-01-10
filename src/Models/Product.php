<?php

namespace Dev3bdulrahman\LicenseManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
    ];

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }
}
