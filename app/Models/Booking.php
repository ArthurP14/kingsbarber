<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'reference',
        'service_id',
        'barber_id',
        'booking_date',
        'start_minute',
        'customer_name',
        'customer_phone',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}