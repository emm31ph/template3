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
        $datas = DB::connection('mysql2')->select('select BRANCH,CUSTNO,ITEMCODE,PRICE,DISCOUNT,DISCOUNT2,DISCOUNT3,DISCOUNT4,DISCOUNT5,UNITPRICE from custitempricelists');
        $chucks = array_chunk($datas,500);
        foreach($chucks as $chuck ){
        foreach($chuck as $data ){
        
        
            $item = [
                        [ 
                            'branch' => $data->BRANCH, 
                            'custno' =>  $data->CUSTNO, 
                            'itemcode' => $data->ITEMCODE, 
                            'price' => $data->PRICE*100, 
                            'discount' => $data->DISCOUNT*100, 
                            'discount2' => $data->DISCOUNT2*100, 
                            'discount3' => $data->DISCOUNT3*100, 
                            'discount4' => $data->DISCOUNT4*100, 
                            'discount5' => $data->DISCOUNT5*100, 
                            'unitprice' => $data->UNITPRICE*100, 
                             
                        ],
                    ]; 
            DB::table('price_customer_lists')->insert($item); 
        } 
    }
    }
}
