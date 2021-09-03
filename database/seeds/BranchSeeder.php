<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['branch' => 'BIC', 'branchname' => 'BICOL'],
            ['branch' => 'BTN', 'branchname' => 'BICUTAN'],
            ['branch' => 'CEB', 'branchname' => 'CEBU'],
            ['branch' => 'DVO', 'branchname' => 'DAVAO'],
            ['branch' => 'GEN', 'branchname' => 'GEN SAN (CCC)'],
            ['branch' => 'ILO', 'branchname' => 'ILOILO'],
            ['branch' => 'MAIN', 'branchname' => 'BAESA'],
            ['branch' => 'MEYC', 'branchname' => 'MEYCAUAYAN'],
            ['branch' => 'ZAM', 'branchname' => 'ZAMBOANGA'],

        ];

        DB::table('branches')->insert($data);

    }
}