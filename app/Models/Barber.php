<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    protected $fillable = ['slug', 'name', 'role', 'bio'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}