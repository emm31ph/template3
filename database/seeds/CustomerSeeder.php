<?php

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        $datas = DB::connection('mysql2')->select('select BRANCH,CUSTNO,CUSTNAME, PRICELIST,ACTIVE,U_REGION,SALESPERSON from customers');
       
        $chucks = array_chunk($datas,500);
        foreach($chucks as $chuck ){
        foreach($chuck as $data ){
        
            $item = [
                        [
                            'branch' => $data->BRANCH, 
                            'custno' =>  $data->CUSTNO, 
                            'custname' => $data->CUSTNAME, 
                            'pricelist' => $data->PRICELIST, 
                            'status' => $data->ACTIVE, 
                            'region' => $data->U_REGION,
                            'salesperson' => $data->SALESPERSON
                        ],
                    ]; 
            DB::table('customers')->insert($item); 
            } 
        }
        
    }
}
