<?php

use App\Models\Signatory;
use Illuminate\Database\Seeder;

class SignatorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('signatories')->insert([
        //     'type' => 'RO001',
        //     'signatories' => 'Prepared By',
        //     'signee' => 'Admin 2',
        //     'designation' => 'Administrator',
        // ]);
        // DB::table('signatories')->insert([
        //     'type' => 'RO001',
        //     'signatories' => 'Prepared By',
        //     'signee' => 'Admin 2',
        //     'designation' => 'Administrator',
        // ]);
        // DB::table('signatories')->insert([
        //     'type' => 'RO001',
        //     'signatories' => 'Prepared By',
        //     'signee' => 'Admin 2',
        //     'designation' => 'Administrator',
        // ]);


        
        // DB::table('signatories')->insert([
        //     'type' => 'DL001',
        //     'signatories' => 'Checked By',
        //     'signee' => 'Admin 2',
        //     'designation' => 'Administrator',
        // ]);

        // DB::table('signatories')->insert([
        //     'type' => 'SH001',
        //     'signatories' => 'Prepared By',
        //     'signee' => 'Admin 2',
        //     'designation' => 'Assistant Logisttics',
        // ]);
        // DB::table('signatories')->insert([
        //     'type' => 'SH001',
        //     'signatories' => 'Approve By',
        //     'signee' => 'Admin 2',
        //     'designation' => 'President',
        // ]);

        $branch = ['MAIN','CEB','ILO','MEY','BIC','ZAM','GEN','DAV','BTN'];

        $counter = [
            [
                'cnt'=> 3,
                'type'=> 'RO001',
                'signatories' =>'Checked By',
                'signee' => 'Admin 2',
                'designation' =>   'Administrator'
            ],[
                'cnt'=> 2,
                'type'=> 'DL001',
                'signatories' =>'Checked By',
                'signee' => 'Admin 2',
                'designation' =>   'Administrator'
            ],[
                'cnt'=> 2,
                'type'=> 'RR001',
                'signatories' =>'Checked By',
                'signee' => 'Admin 2',
                'designation' =>   'Administrator'
            ],[
                'cnt'=> 2,
                'type'=> 'RM001',
                'signatories' =>'Checked By',
                'signee' => 'Admin 2',
                'designation' =>   'Administrator'
            ],[
                'cnt'=> 2,
                'type'=> 'RJ001',
                'signatories' =>'Checked By',
                'signee' => 'Admin 2',
                'designation' =>   'Administrator'
            ],[
                'cnt'=> 2,
                'type'=> 'AD001',
                'signatories' =>'Checked By',
                'signee' => 'Admin 2',
                'designation' =>   'Administrator'
            ],[
                'cnt'=> 2,
                'type'=> 'SH001',
                'signatories' =>'Checked By',
                'signee' => 'Admin 2',
                'designation' =>   'Administrator'
            ],
                    
        ];


        foreach ($branch  as $value) {
            foreach ($counter  as $value2) {
                 for ($i=0; $i <$value2['cnt'] ; $i++) { 
                    $data = [
                        [
                            'type' => $value2['type'],
                            'branch' => $value,
                            'signatories' =>  $value2['signatories'],
                            'signee' =>  $value2['signee'].' '.$i,
                            'designation' =>  $value2['designation'] .' '.$i, 
                            'created_at' => now(), 
                            'updated_at' => now(), 
                        ] 
                        ];

                        Signatory::insert($data);
                 }
            }
        }
    }
}
