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
         

        $branch = ['MAIN','CEB','ILO','MEYC','BIC','ZAM','GEN','DAV','BTN'];
        $counter = [
            [
                'name'=> 'DELIVERY',
                'prefix' =>'DLVR',
                'value' => 1, 
            ], [
                'name'=> 'RRM',
                'prefix' =>'RRM',
                'value' => 1, 
            ], [
                'name'=> 'FPTD',
                'prefix' =>'WP',
                'value' => 1, 
            ], [
                'name'=> 'RR',
                'prefix' =>'RR',
                'value' => 1, 
            ], [
                'name'=> 'REJECT',
                'prefix' =>'RJ',
                'value' => 1, 
            ], [
                'name'=> 'IMPORT',
                'prefix' =>'IMP',
                'value' => 1, 
            ], [
                'name'=> 'ADJUSTMENT',
                'prefix' =>'ADJ',
                'value' => 1, 
            ], [
                'name'=> 'REVERSAL',
                'prefix' =>'REV',
                'value' => 1, 
            ], [
                'name'=> 'CANCEL',
                'prefix' =>'CAN',
                'value' => 1, 
            ], [
                'name'=> 'SHIPPING',
                'prefix' =>'SH',
                'value' => 1, 
            ], [
                'name'=> 'PACKING',
                'prefix' =>'PL',
                'value' => 1, 
            ], [
                'name'=> 'BOOKING',
                'prefix' =>'BK',
                'value' => 1, 
            ]
        ];


        foreach ($branch  as $value) {
            foreach ($counter  as $value1) {
             
                $data = [
                        [
                            'key' => $value1['name'],
                            'branch' => $value,
                            'prefix' => $value1['prefix']."-". $value."-",
                            'value' => 1, 
                            'created_at' => now(), 
                            'updated_at' => now(), 
                        ] 
                        ];

                Counter::insert($data);
            }
        }
        
    }
}