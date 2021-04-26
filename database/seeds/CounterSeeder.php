<?php

use App\Models\Counter;
use Illuminate\Database\Seeder;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Counter::create([
            'key' => 'DELIVERY',
            'prefix' => 'DLVR-',
            'value' => 1,
        ]);

        Counter::create([
            'key' => 'RR',
            'prefix' => 'RR-',
            'value' => 1,
        ]);
        Counter::create([
            'key' => 'WP',
            'prefix' => 'WP-',
            'value' => 1,
        ]);

        Counter::create([
            'key' => 'BL',
            'prefix' => 'BL-',
            'value' => 1,
        ]);
        Counter::create([
            'key' => 'RT',
            'prefix' => 'RT-',
            'value' => 1,
        ]);
        Counter::create([
            'key' => 'IMPORT',
            'prefix' => 'IMP-',
            'value' => 1,
        ]);

    }
}
