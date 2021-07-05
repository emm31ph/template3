<?php

use Illuminate\Database\Seeder;

class PriceCategoryListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Price Category');
        $datas = DB::connection('mysql2')->select('select PRICELIST,PRICELISTNAME from pricelists');
        $chucks = array_chunk($datas,500);
        foreach($chucks as $chuck ){
        foreach($chuck as $data ){
        
        
            $item = [
                        [ 
                            'fulltitle' => $data->PRICELISTNAME, 
                            'pricelist' => $data->PRICELIST, 
                             
                        ],
                    ]; 
            DB::table('price_category_lists')->insert($item); 
        } }
    }
}
