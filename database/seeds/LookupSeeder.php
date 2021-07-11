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
                'code' =>  '001', 
                'fulltitle' => 'Staff', 
                'fulldesc' => 'Staff',  
            ],
            [
                'lookup' => 'U01', 
                'code' =>  '002', 
                'fulltitle' => 'Sales', 
                'fulldesc' => 'Sales',  
            ],
            //
            [
                'lookup' => 'G01', 
                'code' =>  '001', 
                'fulltitle' => 'Male', 
                'fulldesc' => 'Male',  
            ],
            [
                'lookup' => 'G01', 
                'code' =>  '002', 
                'fulltitle' => 'Female', 
                'fulldesc' => 'Female',  
            ],
        ]; 
    DB::table('lookups')->insert($item); 
    }
}
