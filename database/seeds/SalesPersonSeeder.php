<?php

use Illuminate\Database\Seeder;

class SalesPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = DB::connection('mysql2')->select('select SALESPERSON,SALESPERSONNAME,USERID from salespersons');
        $chucks = array_chunk($datas,500);
        foreach($chucks as $chuck ){
            foreach($chuck as $data ){
            
            
                $item = [
                            [ 
                                'salesperson' => $data->SALESPERSON, 
                                'salespersonname' => $data->SALESPERSONNAME,  
                                
                            ],
                        ]; 
                DB::table('sales_persons')->insert($item); 
            } 
        }
    }
}
