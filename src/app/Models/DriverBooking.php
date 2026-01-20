<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'pickup_location',
        'dropoff_location',
        'notes',
        'status',
        'booking_date',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
    ];
}
