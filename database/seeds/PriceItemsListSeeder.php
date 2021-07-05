<?php

use Illuminate\Database\Seeder;

class PriceItemsListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = DB::connection('mysql2')->select('select ITEMCODE,PRICELIST,PRICE*100 as PRICE from itempricelists');
        $chucks = array_chunk($datas,500);
        foreach($chucks as $chuck ){
        foreach($chuck as $data ){
        
        
            $item = [
                        [ 
                            'itemcode' => $data->ITEMCODE, 
                            'price' => $data->PRICE, 
                            'pricelist' => $data->PRICELIST, 
                             
                        ],
                    ]; 
            DB::table('price_items_lists')->insert($item); 
        } 
    }
    }
}
