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
        $datas = DB::connection('mysql2')->select("select  '' shortcode, U_STOCKCODE,ITEMCODE, replace(ITEMDESC,'**',' YT') ITEMDESC,ITEMCLASS,
        CASE LOCATE(CONCAT(CONVERT(ROUND(NUMPERUOMPU,0),CHAR),MID(ITEMDESC,LOCATE('/',ITEMDESC,4),5)),ITEMDESC,4) WHEN 0 THEN
        '' ELSE   CONCAT(CONVERT(ROUND(NUMPERUOMPU,0),CHAR),MID(ITEMDESC,LOCATE('/',ITEMDESC,4),5)) END AS PCKGSIZE,  UOMPU,isvalid,
        CONVERT(ROUND(NUMPERUOMPU,0),CHAR) NUMPERUOMPU,  ITEMCLASS  from items where ITEMCLASS not in ('005','006','004') order by itemdesc");
       
        $chucks = array_chunk($datas,500);
        foreach($chucks as $chuck ){
        foreach($chuck as $data ){
        
            $data = [
                        [
                            'shortcode' => $data->shortcode, 
                            'u_stockcode' =>  $data->U_STOCKCODE, 
                            'itemcode' => $data->ITEMCODE, 
                            'itemdesc' => $data->ITEMDESC, 
                            'pckgsize' => $data->PCKGSIZE, 
                            'uompu' => $data->UOMPU, 
                            'numperuompu' => $data->NUMPERUOMPU,
                            'status' => $data->isvalid,
                            'itemclass' => $data->ITEMCLASS
                        ],
                    ]; 
                    Item::insert($data);
                }
            }
       
    }
}
