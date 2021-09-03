<?php

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = DB::connection('mysql2')->select("select  '' shortcode, U_STOCKCODE,ITEMCODE,replace(ITEMDESC,'**',' YT')  ITEMDESC,ITEMCLASS,
            CASE LOCATE(CONCAT(CONVERT(ROUND(NUMPERUOMPU,0),CHAR),MID(ITEMDESC,LOCATE('/',ITEMDESC,4),5)),ITEMDESC,4) WHEN 0 THEN
            '' ELSE   CONCAT(CONVERT(ROUND(NUMPERUOMPU,0),CHAR),MID(ITEMDESC,LOCATE('/',ITEMDESC,4),5)) END AS PCKGSIZE,  UOMPU,isvalid,
            CONVERT(ROUND(NUMPERUOMPU,0),CHAR) NUMPERUOMPU,  ITEMCLASS,ITEMGROUP  from items where ITEMCLASS not in ('005','006','004') order by itemdesc");
        
            $chucks = array_chunk($datas,500);
            foreach($chucks as $chuck ){
                foreach($chuck as $data ){ 
                    Item::updateOrCreate(['itemcode' => $data->ITEMCODE],[
                        'shortcode' => $data->shortcode, 
                        'u_stockcode' =>  $data->U_STOCKCODE, 
                        'itemcode' => $data->ITEMCODE, 
                        'itemdesc' => $data->ITEMDESC, 
                        'pckgsize' => $data->PCKGSIZE, 
                        'uompu' => $data->UOMPU, 
                        'numperuompu' => $data->NUMPERUOMPU,
                        'status' => $data->isvalid,
                        'itemclass' => $data->ITEMCLASS,
                        'itemgroup' => $data->ITEMGROUP
                    ],);
                }
            }

        $data = [
            [
                'shortcode' => 'REJECT',
                'u_stockcode' => 'REJECT',
                'itemcode' => 'REJECT',
                'itemdesc' => 'REJECT',
                'pckgsize' => 'ALL',
                'uompu' => 'ALL',
                'numperuompu' => '1',
                'status' => '0',
                'itemclass' => '1',
            ],
        ];
        Item::insert($data);

        $data = [
            ['branch' => 'BIC', 'qty' => 0, 'itemcode' => 'REJECT', 'expdate' => '2099-01-01', 'status' => '0'],
            ['branch' => 'BTN', 'qty' => 0, 'itemcode' => 'REJECT', 'expdate' => '2099-01-01', 'status' => '0'],
            ['branch' => 'CEB', 'qty' => 0, 'itemcode' => 'REJECT', 'expdate' => '2099-01-01', 'status' => '0'],
            ['branch' => 'DAV', 'qty' => 0, 'itemcode' => 'REJECT', 'expdate' => '2099-01-01', 'status' => '0'],
            ['branch' => 'GEN', 'qty' => 0, 'itemcode' => 'REJECT', 'expdate' => '2099-01-01', 'status' => '0'],
            ['branch' => 'ILO', 'qty' => 0, 'itemcode' => 'REJECT', 'expdate' => '2099-01-01', 'status' => '0'],
            ['branch' => 'MAIN', 'qty' => 0, 'itemcode' => 'REJECT', 'expdate' => '2099-01-01', 'status' => '0'],
            ['branch' => 'MEY', 'qty' => 0, 'itemcode' => 'REJECT', 'expdate' => '2099-01-01', 'status' => '0'],
            ['branch' => 'ZAM', 'qty' => 0, 'itemcode' => 'REJECT', 'expdate' => '2099-01-01', 'status' => '0'],
        ];
        DB::table('items_branches')->insert($data);
    }
}