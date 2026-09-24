<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['slug', 'name', 'price', 'duration', 'sort_order'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}