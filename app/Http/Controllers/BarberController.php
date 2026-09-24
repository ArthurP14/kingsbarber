<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class BarberController extends Controller
{
    /**
     * Opening hours by day-of-week (0 = Sunday).
     * null = closed. [open_hour, close_hour] in 24-hour format.
     */
    public const HOURS = [
        0 => [10, 15],   // Sunday
        1 => null,       // Monday — closed
        2 => [9, 19],    // Tuesday
        3 => [9, 19],    // Wednesday
        4 => [9, 19],    // Thursday
        5 => [9, 19],    // Friday
        6 => [8, 17],    // Saturday
    ];

    public const DAYNAMES = [
        'Sunday', 'Monday', 'Tuesday', 'Wednesday',
        'Thursday', 'Friday', 'Saturday',
    ];

    /** Render the homepage */
    public function index(): View
    {
        return view('barbers.index', [
            'services' => Service::orderBy('sort_order')->get(),
            'barbers'  => Barber::orderBy('id')->get(),
            'hours'    => self::HOURS,
            'dayNames' => self::DAYNAMES,
        ]);
    }

    /** GET /api/services */
    public function services(): JsonResponse
    {
        return response()->json(Service::orderBy('sort_order')->get());
    }

    /** GET /api/barbers */
    public function barbers(): JsonResponse
    {
        return response()->json(Barber::orderBy('id')->get());
    }

    /** GET /api/hours */
    public function hours(): JsonResponse
    {
        return response()->json([
            'hours'    => self::HOURS,
            'dayNames' => self::DAYNAMES,
        ]);
    }

    /** GET /api/status — is the shop open right now? */
    public function status(): JsonResponse
    {
        $now   = Carbon::now();
        $day   = (int) $now->dayOfWeek;
        $mins  = $now->hour * 60 + $now->minute;
        $today = self::HOURS[$day] ?? null;

        if ($today && $mins >= $today[0] * 60 && $mins < $today[1] * 60) {
            return response()->json([
                'open'    => true,
                'message' => 'Open now until ' . self::fmt($today[1] * 60),
            ]);
        }

        for ($i = 0; $i < 8; $i++) {
            $d  = $now->copy()->addDays($i);
            $hh = self::HOURS[(int) $d->dayOfWeek] ?? null;

            if ($hh && ($i > 0 || $mins < $hh[0] * 60)) {
                $label = match (true) {
                    $i === 0 => 'today',
                    $i === 1 => 'tomorrow',
                    default  => self::DAYNAMES[$d->dayOfWeek],
                };

                return response()->json([
                    'open'    => false,
                    'message' => "Closed now. Opens {$label} at " . self::fmt($hh[0] * 60),
                ]);
            }
        }

        return response()->json(['open' => false, 'message' => 'Closed']);
    }

    /** Format minutes-from-midnight as "9am" / "5:30pm" */
    public static function fmt(int $minutes): string
    {
        $h   = intdiv($minutes, 60);
        $m   = $minutes % 60;
        $ap  = $h >= 12 ? 'pm' : 'am';
        $h12 = (($h + 11) % 12) + 1;

        return $h12 . ($m ? ':' . str_pad($m, 2, '0', STR_PAD_LEFT) : '') . ' ' . $ap;
    }
}