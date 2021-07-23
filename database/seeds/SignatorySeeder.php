<?php

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
        DB::table('signatories')->insert([
            'type' => 'RO001',
            'signatories' => 'Prepared By',
            'signee' => 'Admin 2',
            'designation' => 'Administrator',
        ]);
        DB::table('signatories')->insert([
            'type' => 'RO001',
            'signatories' => 'Prepared By',
            'signee' => 'Admin 2',
            'designation' => 'Administrator',
        ]);
        DB::table('signatories')->insert([
            'type' => 'RO001',
            'signatories' => 'Prepared By',
            'signee' => 'Admin 2',
            'designation' => 'Administrator',
        ]);


        
        DB::table('signatories')->insert([
            'type' => 'DL001',
            'signatories' => 'Checked By',
            'signee' => 'Admin 2',
            'designation' => 'Administrator',
        ]);

    }
}
