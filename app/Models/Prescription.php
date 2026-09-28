<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'dental_record_id',
        'notes',
    ];

    public function dentalRecord()
    {
        return $this->belongsTo(DentalRecord::class);
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
    }
}