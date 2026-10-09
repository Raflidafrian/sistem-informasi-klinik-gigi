<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'min_price',
        'max_price',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function billingItems()
    {
        return $this->hasMany(BillingItem::class);
    }
}