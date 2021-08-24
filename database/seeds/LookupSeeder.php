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
            [
                'lookup' => 'R01',
                'code' => 'R001',
                'fulltitle' => 'SHIPPING ADVICE',
                'fulldesc' => 'SHIPPING ADVICE',
            ],
            [
                'lookup' => 'R01',
                'code' => 'R002',
                'fulltitle' => 'PACKING LIST',
                'fulldesc' => 'PACKING LIST',
            ],
            [
                'lookup' => 'R01',
                'code' => 'R003',
                'fulltitle' => 'INVENTORY',
                'fulldesc' => 'INVENTORY',
            ],
            //user type
            [
                'lookup' => 'U01',
                'code' => 'U001',
                'fulltitle' => 'Staff',
                'fulldesc' => 'Staff',
            ],
            [
                'lookup' => 'U01',
                'code' => 'U002',
                'fulltitle' => 'Sales',
                'fulldesc' => 'Sales',
            ],
            //
            [
                'lookup' => 'G01',
                'code' => 'C001',
                'fulltitle' => 'Male',
                'fulldesc' => 'Male',
            ],
            [
                'lookup' => 'G01',
                'code' => 'C002',
                'fulltitle' => 'Female',
                'fulldesc' => 'Female',
            ],

            [
                'lookup' => 'UOM1',
                'code' => 'CASE',
                'fulltitle' => 'CASE',
                'fulldesc' => 'CASES',
            ],
            [
                'lookup' => 'UOM1',
                'code' => 'TIN',
                'fulltitle' => 'TIN',
                'fulldesc' => 'TINS',
            ],
            [
                'lookup' => 'UOM1',
                'code' => 'U003',
                'fulltitle' => 'KILO',
                'fulldesc' => 'KILOS',
            ],
            [
                'lookup' => 'UOM1',
                'code' => 'U004',
                'fulltitle' => 'LITER',
                'fulldesc' => 'LITERS',
            ],
            [
                'lookup' => 'UOM1',
                'code' => 'U005',
                'fulltitle' => 'GALLON',
                'fulldesc' => 'GALLONS',
            ],
            [
                'lookup' => 'UOM1',
                'code' => 'U006',
                'fulltitle' => 'DRUM',
                'fulldesc' => 'DRUMS',
            ],
            [
                'lookup' => 'UOM1',
                'code' => 'U007',
                'fulltitle' => 'CRUSHED GRAHAM',
                'fulldesc' => 'CRUSHED GRAHAM',
            ],

            [
                'lookup' => 'REG0',
                'code' => 'RG01',
                'fulltitle' => '',
                'fulldesc' => '',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'ARMM',
                'fulltitle' => 'ARMM',
                'fulldesc' => 'Autonomous Region of Muslim Mindanao',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'CAR',
                'fulltitle' => 'CAR',
                'fulldesc' => 'Cordillera Administrative Region',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'I',
                'fulltitle' => 'I',
                'fulldesc' => 'Ilocos',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'II',
                'fulltitle' => 'II',
                'fulldesc' => 'Cagayan Valley',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'III',
                'fulltitle' => 'III',
                'fulldesc' => 'Central Luzon',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'IV',
                'fulltitle' => 'IV',
                'fulldesc' => 'CALABARZON/MIMAROPA',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'IX',
                'fulltitle' => 'IX',
                'fulldesc' => 'Zamboanga Peninsula',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'NCR',
                'fulltitle' => 'NCR',
                'fulldesc' => 'National Capital Region',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'V',
                'fulltitle' => 'V',
                'fulldesc' => 'Bicol',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'VI',
                'fulltitle' => 'VI',
                'fulldesc' => 'Iloilo',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'VII',
                'fulltitle' => 'VII',
                'fulldesc' => 'Central Visayas',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'VIII',
                'fulltitle' => 'VIII',
                'fulldesc' => 'Easterm Visayas',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'X',
                'fulltitle' => 'X',
                'fulldesc' => 'Northen Mindanao',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'XI',
                'fulltitle' => 'XI',
                'fulldesc' => 'Davao',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'XII',
                'fulltitle' => 'XII',
                'fulldesc' => 'SOCCSKSARGEN',
            ],
            [
                'lookup' => 'REG0',
                'code' => 'XIII',
                'fulltitle' => 'XIII',
                'fulldesc' => 'CARAGA',
            ], 
            [
                'lookup' => 'LOGS',
                'code' => 'LGDR',
                'fulltitle' => 'YES',
                'fulldesc' => 'BASE ON DR on NOT',
            ],

        ];
        DB::table('lookups')->insert($item);
    }
}
