<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function availability(Request $request): JsonResponse
    {
        $data = $request->validate([
            'date'       => 'required|date_format:Y-m-d',
            'service_id' => 'required|integer|exists:services,id',
            'barber_id'  => 'nullable',
        ]);

        $svc   = Service::findOrFail($data['service_id']);
        $date  = Carbon::createFromFormat('Y-m-d', $data['date'])->startOfDay();
        $day   = (int) $date->dayOfWeek;
        $hours = BarberController::HOURS[$day] ?? null;

        if (! $hours) {
            return response()->json(['slots' => []]);
        }

        $requested = $request->input('barber_id', 'any');
        $barbers   = ($requested === 'any' || $requested === null || $requested === '')
            ? Barber::all()
            : Barber::where('id', $requested)->get();

        $booked = Booking::where('booking_date', $date->toDateString())
            ->get()
            ->groupBy('barber_id')
            ->map(fn ($rows) => $rows->pluck('start_minute')->flip());

        $now   = Carbon::now();
        $slots = [];

        for ($m = $hours[0] * 60; $m + $svc->duration <= $hours[1] * 60; $m += 30) {
            $start = $date->copy()->addMinutes($m);

            $freeBarbers = $barbers->filter(function ($barber) use ($booked, $m, $svc) {
                $taken = $booked[$barber->id] ?? collect();
                for ($check = $m; $check < $m + $svc->duration; $check += 30) {
                    if ($taken->has($check)) {
                        return false;
                    }
                }
                return true;
            })->values();

            $slots[] = [
                'minute'    => $m,
                'label'     => BarberController::fmt($m),
                'available' => $start->greaterThan($now) && $freeBarbers->isNotEmpty(),
                'barber_id' => optional($freeBarbers->first())->id,
            ];
        }

        return response()->json(['slots' => $slots]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'service_id'     => 'required|integer|exists:services,id',
            'barber_id'      => 'required|integer|exists:barbers,id',
            'date'           => 'required|date_format:Y-m-d|after_or_equal:today',
            'start_minute'   => 'required|integer|min:0|max:1439',
            'customer_name'  => 'required|string|max:120',
            'customer_phone' => 'required|string|min:7|max:32',
        ]);

        // Double-booking guard
        $conflict = Booking::where('barber_id', $data['barber_id'])
            ->where('booking_date', $data['date'])
            ->where('start_minute', $data['start_minute'])
            ->exists();

        if ($conflict) {
            return response()->json([
                'message' => 'That time was just taken. Please choose another slot.',
            ], 409);
        }

        try {
            $booking = Booking::create([
                'reference'      => 'KB-' . strtoupper(Str::random(4)),
                'service_id'     => $data['service_id'],
                'barber_id'      => $data['barber_id'],
                'booking_date'   => $data['date'],
                'start_minute'   => $data['start_minute'],
                'customer_name'  => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'That time was just taken. Please choose another slot.',
            ], 409);
        }

        return response()->json([
            'reference' => $booking->reference,
            'booking'   => $booking->load('service', 'barber'),
        ], 201);
    }
}
