<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['slug' => 'cut',   'name' => 'Haircut',              'price' => 25, 'duration' => 40],
            ['slug' => 'fade',  'name' => 'Skin fade',            'price' => 30, 'duration' => 45],
            ['slug' => 'beard', 'name' => 'Beard trim and shape', 'price' => 18, 'duration' => 30],
            ['slug' => 'shave', 'name' => 'Hot towel shave',      'price' => 28, 'duration' => 30],
            ['slug' => 'combo', 'name' => 'Cut and beard',        'price' => 40, 'duration' => 60],
            ['slug' => 'kids',  'name' => 'Kids cut, under 12',   'price' => 18, 'duration' => 30],
            ['slug' => 'line',  'name' => 'Line design',          'price' => 8,  'duration' => 30],
            ['slug' => 'grey',  'name' => 'Colour and dye',       'price' => 20, 'duration' => 60],
        ];

        foreach ($services as $i => $s) {
            Service::updateOrCreate(
                ['slug' => $s['slug']],
                $s + ['sort_order' => $i]
            );
        }

        $barbers = [
            ['slug' => 'tendai',  'name' => 'Tendai',  'role' => 'Fades and tapers',
             'bio' => 'Fifteen years behind the chair. Clean blends, sharp lines, and patience for anyone who has never had a fade.'],
            ['slug' => 'marcus',  'name' => 'Marcus',  'role' => 'Classic cuts and razor work',
             'bio' => 'Scissor-over-comb, side parts and the hot towel shave the shop is known for.'],
            ['slug' => 'lindiwe', 'name' => 'Lindiwe', 'role' => 'Beards and textured hair',
             'bio' => 'Shapes beards to the face, and knows what to do with curls, coils and waves.'],
        ];

        foreach ($barbers as $b) {
            Barber::updateOrCreate(['slug' => $b['slug']], $b);
        }
    }
}