<?php

use Illuminate\Database\Seeder;

class LookupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = [
            //user type
            [
                'lookup' => 'U01', 
                'code' =>  'U001', 
                'fulltitle' => 'Staff', 
                'fulldesc' => 'Staff',  
            ],
            [
                'lookup' => 'U01', 
                'code' =>  'U002', 
                'fulltitle' => 'Sales', 
                'fulldesc' => 'Sales',  
            ],
            //
            [
                'lookup' => 'G01', 
                'code' =>  'C001', 
                'fulltitle' => 'Male', 
                'fulldesc' => 'Male',  
            ],
            [
                'lookup' => 'G01', 
                'code' =>  'C002', 
                'fulltitle' => 'Female', 
                'fulldesc' => 'Female',  
            ],

            
            [
                'lookup' => 'UOM1', 
                'code' =>  'CASE', 
                'fulltitle' => 'CASE', 
                'fulldesc' => 'CASES',  
            ], 
            [
                'lookup' => 'UOM1', 
                'code' =>  'TIN', 
                'fulltitle' => 'TIN', 
                'fulldesc' => 'TINS',  
            ], 
            [
                'lookup' => 'UOM1', 
                'code' =>  'U003', 
                'fulltitle' => 'KILO', 
                'fulldesc' => 'KILOS',  
            ], 
            [
                'lookup' => 'UOM1', 
                'code' =>  'U004', 
                'fulltitle' => 'LITER', 
                'fulldesc' => 'LITERS',  
            ], 
            [
                'lookup' => 'UOM1', 
                'code' =>  'U005', 
                'fulltitle' => 'GALLON', 
                'fulldesc' => 'GALLONS',  
            ], 
            [
                'lookup' => 'UOM1', 
                'code' =>  'U006', 
                'fulltitle' => 'DRUM', 
                'fulldesc' => 'DRUMS',  
            ],
            [
                'lookup' => 'UOM1', 
                'code' =>  'U007', 
                'fulltitle' => 'CRUSHED GRAHAM', 
                'fulldesc' => 'CRUSHED GRAHAM',  
            ], 
        ]; 
    DB::table('lookups')->insert($item); 
    }
}
