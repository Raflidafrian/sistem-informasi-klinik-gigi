<?php

namespace App\Models;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'birth_date',
        'gender',
        'address',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function dentalRecords()
    {
        return $this->hasMany(DentalRecord::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }
}