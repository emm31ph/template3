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
        $data = [
            [
                'key' => 'DELIVERY',
                'branch' => 'MAIN',
                'prefix' => 'DLVR-MAIN-',
                'value' => 1,
            ], [
                'key' => 'RRM',
                'branch' => 'MAIN',
                'prefix' => 'RRM-MAIN-',
                'value' => 1,
            ], [
                'key' => 'FPTD',
                'branch' => 'MAIN',
                'prefix' => 'WP-MAIN-',
                'value' => 1,
            ], [
                'key' => 'RJCT',
                'branch' => 'MAIN',
                'prefix' => 'RJ-MAIN-',
                'value' => 1,
            ], [
                'key' => 'RR',
                'branch' => 'MAIN',
                'prefix' => 'RR-MAIN-',
                'value' => 1,
            ], [
                'key' => 'IMPORT',
                'branch' => 'MAIN',
                'prefix' => 'IMP-MAIN-',
                'value' => 1,
            ], [
                'key' => 'ADJUSTMENT',
                'branch' => 'MAIN',
                'prefix' => 'ADJ-MAIN-',
                'value' => 1,
            ]];

        Counter::insert($data);

        $data = [
            [
                'key' => 'DELIVERY',
                'branch' => 'CEB',
                'prefix' => 'DLVR-CEB-',
                'value' => 1,
            ], [
                'key' => 'RRM',
                'branch' => 'CEB',
                'prefix' => 'RRM-CEB-',
                'value' => 1,
            ], [
                'key' => 'FPTD',
                'branch' => 'CEB',
                'prefix' => 'WP-CEB-',
                'value' => 1,
            ], [
                'key' => 'RJCT',
                'branch' => 'CEB',
                'prefix' => 'RJ-CEB-',
                'value' => 1,
            ], [
                'key' => 'RR',
                'branch' => 'CEB',
                'prefix' => 'RR-CEB-',
                'value' => 1,
            ], [
                'key' => 'IMPORT',
                'branch' => 'CEB',
                'prefix' => 'IMP-CEB-',
                'value' => 1,
            ], [
                'key' => 'ADJUSTMENT',
                'branch' => 'CEB',
                'prefix' => 'ADJ-CEB-',
                'value' => 1,
            ]];

        Counter::insert($data);

        $data = [
            [
                'key' => 'DELIVERY',
                'branch' => 'ILO',
                'prefix' => 'DLVR-ILO-',
                'value' => 1,
            ], [
                'key' => 'RRM',
                'branch' => 'ILO',
                'prefix' => 'RRM-ILO-',
                'value' => 1,
            ], [
                'key' => 'FPTD',
                'branch' => 'ILO',
                'prefix' => 'WP-ILO-',
                'value' => 1,
            ], [
                'key' => 'RJCT',
                'branch' => 'ILO',
                'prefix' => 'RJ-ILO-',
                'value' => 1,
            ], [
                'key' => 'RR',
                'branch' => 'ILO',
                'prefix' => 'RR-ILO-',
                'value' => 1,
            ], [
                'key' => 'IMPORT',
                'branch' => 'ILO',
                'prefix' => 'IMP-ILO-',
                'value' => 1,
            ], [
                'key' => 'ADJUSTMENT',
                'branch' => 'ILO',
                'prefix' => 'ADJ-ILO-',
                'value' => 1,
            ]];

        Counter::insert($data);

    }
}
