<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\DentalRecord;
use App\Models\BillingItem;
use App\Models\Payment;

class Billing extends Model
{
    protected $fillable = [
        'patient_id',
        'dental_record_id',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dentalRecord()
    {
        return $this->belongsTo(DentalRecord::class);
    }

    public function items()
    {
        return $this->hasMany(BillingItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}