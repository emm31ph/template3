<?php

use Illuminate\Database\Seeder;

class TruckerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['lookup'=>'TR01','code' => 'T001', 'fulltitle' => '','fulldesc' => ''],
            ['lookup'=>'TR01','code' => 'T002', 'fulltitle' => 'AA1-2071','fulldesc' => 'AA1-2071'],
            ['lookup'=>'TR01','code' => 'T003', 'fulltitle' => 'RJV-279','fulldesc' => 'RJV-279'],
            ['lookup'=>'TR01','code' => 'T004', 'fulltitle' => 'RJT-976','fulldesc' => 'RJT-976'],
            ['lookup'=>'TR01','code' => 'T005', 'fulltitle' => 'YCA-764','fulldesc' => 'YCA-764'],
            ['lookup'=>'TR01','code' => 'T006', 'fulltitle' => 'TSB-928','fulldesc' => 'TSB-928'],
            ['lookup'=>'TR01','code' => 'T007', 'fulltitle' => 'RJR-439','fulldesc' => 'RJR-439'],
            ['lookup'=>'TR01','code' => 'T008', 'fulltitle' => 'RJY-725','fulldesc' => 'RJY-725'],
            ['lookup'=>'TR01','code' => 'T009', 'fulltitle' => 'XCK-354','fulldesc' => 'XCK-354'],
            ['lookup'=>'TR01','code' => 'T010', 'fulltitle' => 'WTR-600','fulldesc' => 'WTR-600'],
            ['lookup'=>'TR01','code' => 'T011', 'fulltitle' => 'WDA-456','fulldesc' => 'WDA-456'],
            ['lookup'=>'TR01','code' => 'T012', 'fulltitle' => 'AAN-4656','fulldesc' => 'AAN-4656'],
            ['lookup'=>'TR01','code' => 'T013', 'fulltitle' => 'ABA-9344','fulldesc' => 'ABA-9344'],
            ['lookup'=>'TR01','code' => 'T014', 'fulltitle' => 'LMN-408','fulldesc' => 'LMN-408'],
            ['lookup'=>'TR01','code' => 'T015', 'fulltitle' => 'Third Party','fulldesc' => 'Third Party'],
            ['lookup'=>'TR01','code' => 'T016', 'fulltitle' => 'Interbranch','fulldesc' => 'Interbranch'],
            ['lookup'=>'TR01','code' => 'T017', 'fulltitle' => 'WRQ-167','fulldesc' => 'WRQ-167'],
            ['lookup'=>'TR01','code' => 'T018', 'fulltitle' => 'RGS-266','fulldesc' => 'RGS-266'],
            ['lookup'=>'TR01','code' => 'T019', 'fulltitle' => 'NDB-3308','fulldesc' => 'NDB-3308'],
            ['lookup'=>'TR01','code' => 'T020', 'fulltitle' => 'ALA-8860','fulldesc' => 'ALA-8860'],
            ['lookup'=>'TR01','code' => 'T021', 'fulltitle' => 'ALA-8294','fulldesc' => 'ALA-8294'],
            ['lookup'=>'TR01','code' => 'T022', 'fulltitle' => 'NDB 3307','fulldesc' => 'NDB 3307'],
            ['lookup'=>'TR01','code' => 'T023', 'fulltitle' => 'Cancelled','fulldesc' => 'Cancelled'],
            ['lookup'=>'TR01','code' => 'T024', 'fulltitle' => 'UUE-954','fulldesc' => 'UUE-954'],
            ['lookup'=>'TR01','code' => 'T025', 'fulltitle' => 'NBA-6289','fulldesc' => 'NBA-6289'],
            ['lookup'=>'TR01','code' => 'T026', 'fulltitle' => 'NBA-6288','fulldesc' => 'NBA-6288'],
            ['lookup'=>'TR01','code' => 'T027', 'fulltitle' => 'Pick up','fulldesc' => 'Pick up'],
            ['lookup'=>'TR01','code' => 'T028', 'fulltitle' => 'RJV-310','fulldesc' => 'RJV-310'],
            ['lookup'=>'TR01','code' => 'T029', 'fulltitle' => 'AAN-3736','fulldesc' => 'AAN-3736'],
            ['lookup'=>'TR01','code' => 'T030', 'fulltitle' => 'ACM-2089','fulldesc' => 'ACM-2089'],
            ['lookup'=>'TR01','code' => 'T031', 'fulltitle' => 'CAO-2275','fulldesc' => 'CAO-2275'],
            ['lookup'=>'TR01','code' => 'T032', 'fulltitle' => 'NBB-6909','fulldesc' => 'NBB-6909'],
            ['lookup'=>'TR01','code' => 'T033', 'fulltitle' => 'NAZ-4994','fulldesc' => 'NAZ-4994'],
            ['lookup'=>'TR01','code' => 'T034', 'fulltitle' => 'NAZ-4978','fulldesc' => 'NAZ-4978'],
            ['lookup'=>'TR01','code' => 'T035', 'fulltitle' => 'UTE-389','fulldesc' => 'UTE-389'],
            ['lookup'=>'TR01','code' => 'T036', 'fulltitle' => 'USX-921','fulldesc' => 'USX-921'],
            ['lookup'=>'TR01','code' => 'T037', 'fulltitle' => 'RAA-602','fulldesc' => 'RAA-602'],
            ['lookup'=>'TR01','code' => 'T038', 'fulltitle' => 'XCT-175','fulldesc' => 'XCT-175'],
            ['lookup'=>'TR01','code' => 'T039', 'fulltitle' => 'RCJ-471','fulldesc' => 'RCJ-471'],
            ['lookup'=>'TR01','code' => 'T040', 'fulltitle' => 'ALA-9234','fulldesc' => 'ALA-9234'],
        ];
        DB::table('lookups')->insert($data);

    }
}
