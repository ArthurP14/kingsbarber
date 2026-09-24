<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();

            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('barber_id');

            $table->date('booking_date');
            $table->unsignedInteger('start_minute'); // minutes from midnight
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->timestamps();

            // A barber cannot have two bookings at the same time
            $table->unique(
                ['barber_id', 'booking_date', 'start_minute'],
                'uniq_barber_slot'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
