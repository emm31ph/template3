<?php

use Illuminate\Database\Seeder;

class PriceCustomerListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = DB::connection('mysql2')->select('select BRANCH,CUSTNO,ITEMCODE,PRICE from custitempricelists');
        $chucks = array_chunk($datas,500);
        foreach($chucks as $chuck ){
        foreach($chuck as $data ){
        
        
            $item = [
                        [ 
                            'branch' => $data->BRANCH, 
                            'custno' =>  $data->CUSTNO, 
                            'itemcode' => $data->ITEMCODE, 
                            'price' => $data->PRICE, 
                             
                        ],
                    ]; 
            DB::table('price_customer_lists')->insert($item); 
        } 
    }
    }
}
