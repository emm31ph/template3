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

        $branch = ['MAIN', 'CEB', 'ILO', 'MEY', 'BIC', 'ZAM', 'GEN', 'DVO', 'BTN'];

        $counter = [
            [
                'cnt' => 3,
                'type' => 'RO001',
                'signatories' => 'Checked By',
                'signee' => 'Admin 2',
                'designation' => 'Administrator',
                'lookupcode' => 'R003',
            ], [
                'cnt' => 2,
                'type' => 'DL001',
                'signatories' => 'Checked By',
                'signee' => 'Admin 2',
                'designation' => 'Administrator',
                'lookupcode' => 'R003',
            ], [
                'cnt' => 2,
                'type' => 'RR001',
                'signatories' => 'Checked By',
                'signee' => 'Admin 2',
                'designation' => 'Administrator',
                'lookupcode' => 'R003',
            ], [
                'cnt' => 2,
                'type' => 'RM001',
                'signatories' => 'Checked By',
                'signee' => 'Admin 2',
                'designation' => 'Administrator',
                'lookupcode' => 'R003',
            ], [
                'cnt' => 2,
                'type' => 'RJ001',
                'signatories' => 'Checked By',
                'signee' => 'Admin 2',
                'designation' => 'Administrator',
                'lookupcode' => 'R003',
            ], [
                'cnt' => 2,
                'type' => 'AD001',
                'signatories' => 'Checked By',
                'signee' => 'Admin 2',
                'designation' => 'Administrator',
                'lookupcode' => 'R003',
            ], [
                'cnt' => 1,
                'type' => 'SH001',
                'signatories' => 'Checked By',
                'signee' => 'Kreus Pagulayan',
                'designation' => 'Log. Trans. Assistant',
                'lookupcode' => 'R001',
            ], [
                'cnt' => 1,
                'type' => 'SH001',
                'signatories' => 'Approved By',
                'signee' => 'Candice Chung',
                'designation' => 'President',
                'lookupcode' => 'R001',
            ], [
                'cnt' => 3,
                'type' => 'PL001',
                'signatories' => 'Checked By',
                'signee' => 'Admin 2',
                'designation' => 'Administrator',
                'lookupcode' => 'R002',
            ],

        ];

        foreach ($branch as $value) {
            foreach ($counter as $value2) {
                for ($i = 0; $i < $value2['cnt']; $i++) {
                    $data = [
                        [
                            'type' => $value2['type'],
                            'branch' => $value,
                            'signatories' => $value2['signatories'],
                            'signee' => $value2['signee'],
                            'designation' => $value2['designation'],
                            'lookupcode' => $value2['lookupcode'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                    ];

                    Signatory::insert($data);
                }
            }
        }
    }
}