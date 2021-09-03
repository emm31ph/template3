<?php

use Illuminate\Database\Seeder;

class LCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $item = [
            [
                'lookup' => 'IT1',
                'code' => 'ITM01',
                'fulltitle' => 'LOW COST',
                'fulldesc' => 'LOW COST',
            ],
        ];

        
        DB::table('lookups')->insert($item);

    }
}