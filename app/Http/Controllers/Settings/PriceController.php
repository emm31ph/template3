<?php

namespace App\Http\Controllers\Settings;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\PriceItemsList;
use App\Models\PriceCategoryList;
use App\Models\PriceCustomerList;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{
    public function price(Request $request)
    {

        $data = '';
        // $parm = $request->parms;

        // return \response()->json($request->all(),200);

        switch ($request->trntype) {
            case 'pricelist':
                $data = $this->PriceItems($request);
                break;
            case 'pricecust':
                $data = $this->PriceCustomer($request);
                break;
            case 'pricecat':
                $data = $this->PriceCategory($request);
                break;
            case 'generate': 
                    $data = $this->PriceCategoryGenerate();
                    break; 
            case 'generate-product': 
                $data = $this->ProductGenerate();
                break;
            case 'generate-price-list':
                $data = $this->PriceItemsGenerate();
                break;
            case 'generate-cust-price':
                $data = $this->CustomerPrice();
                break;
            default:
                // PriceItems();
                break;
        }

        return \response()->json($data, 200);
    }
    private function CustomerPrice()
    { 
        
        DB::disableQueryLog();
        DB::beginTransaction();
        try {
            PriceCustomerList::where('branch','=',auth()->user()->branch)->update(['price' => 0,'discount' => 0,'discount2' => 0,'discount3' => 0,'discount4' => 0,'discount5' => 0]);
            $datas = DB::connection('mysql2')->select('select BRANCH,CUSTNO,ITEMCODE,PRICE,DISCOUNT,DISCOUNT2,DISCOUNT3,DISCOUNT4,DISCOUNT5,UNITPRICE from custitempricelists');
            $chucks = array_chunk($datas,500);
            foreach($chucks as $chuck ){
                foreach($chuck as $data ){  
                    PriceCustomerList::updateOrCreate(
                        ['branch' => $data->BRANCH,'custno' =>  $data->CUSTNO,  'itemcode' => $data->ITEMCODE,],
                        ['price' => $data->PRICE*100,
                        'discount' => $data->DISCOUNT*100,
                        'discount2' => $data->DISCOUNT2*100,
                        'discount3' => $data->DISCOUNT3*100,
                        'discount4' => $data->DISCOUNT4*100,
                        'discount5' => $data->DISCOUNT5*100,
                        'unitprice' => $data->UNITPRICE*100,]
                    );

                } 
            }

            PriceCustomerList::where('branch','=',auth()->user()->branch)->where('price','=','0')->delete();

            \DB::commit();
            return $datas;

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    private function PriceItemsGenerate()
    {
        DB::disableQueryLog();
        DB::beginTransaction();
        try {
            
            PriceItemsList::update(['price' => 0]);
            $datas = DB::connection('mysql2')->select('select ITEMCODE,PRICELIST,PRICE*100 as PRICE from itempricelists');
            $chucks = array_chunk($datas,500);
            foreach($chucks as $chuck ){
                foreach($chuck as $data ){
                
                    PriceItemsList::updateOrCreate(['pricelist'=>$data->PRICELIST, 'itemcode' => $data->ITEMCODE],['pricelist' => $data->PRICELIST]);
        
                } 
            }
            \DB::commit();
            return $datas;

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    private function ProductGenerate(){
        DB::disableQueryLog();
        DB::beginTransaction();
        try {
            
            $datas = DB::connection('mysql2')->select("select  '' shortcode, U_STOCKCODE,ITEMCODE,replace(ITEMDESC,'**',' YT')  ITEMDESC,ITEMCLASS,
            CASE LOCATE(CONCAT(CONVERT(ROUND(NUMPERUOMPU,0),CHAR),MID(ITEMDESC,LOCATE('/',ITEMDESC,4),5)),ITEMDESC,4) WHEN 0 THEN
            '' ELSE   CONCAT(CONVERT(ROUND(NUMPERUOMPU,0),CHAR),MID(ITEMDESC,LOCATE('/',ITEMDESC,4),5)) END AS PCKGSIZE,  UOMPU,isvalid,
            CONVERT(ROUND(NUMPERUOMPU,0),CHAR) NUMPERUOMPU,  ITEMCLASS  from items where ITEMCLASS not in ('005','006','004') order by itemdesc");
        
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
                        'itemclass' => $data->ITEMCLASS
                    ],);
                }
            }
            \DB::commit();
            return $datas;

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }
    private function PriceCategoryGenerate()
    {
        DB::disableQueryLog();
        DB::beginTransaction();
        try {
            $datas = DB::connection('mysql2')->select('select PRICELIST,PRICELISTNAME from pricelists');
            $chucks = array_chunk($datas,500);
            foreach($chucks as $chuck ){
                foreach($chuck as $data ){  
                    PriceCategoryList::updateOrCreate(['fulltitle'=>$data->PRICELISTNAME],['fulltitle'=>$data->PRICELISTNAME,'pricelist'=>$data->PRICELIST]);
                } 
            }
            \DB::commit();
            return $datas;

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    private function PriceItems(Request $request)
    {
        $data = PriceItemsList::where('pricelist', $request->pricelist)
            ->with(['items' => function ($builder) {
                $builder->select('itemcode', 'itemdesc');
            }])->get();
        return ['result' => $data];
    }

    public function PriceCategory(Request $request)
    {
        
        DB::disableQueryLog();
        DB::beginTransaction();
        try {
            $data = '';
            // return ['result'=>$request->all()];
            switch ($request->trnmode) {
                case 'new': 
                    $request->validate([
                        'fulltitle' => 'required|unique:price_category_lists',
                        'pricelist' => 'required|unique:price_category_lists',
                    ], [
                        'fulltitle.required' => 'Price Category is required',
                        'fulltitle.unique' => 'Price Category is already exist',
                        'pricelist.required' => 'Price Category ID is required',
                        'pricelist.unique' => 'Price Category ID is already exist',
                    ]);
                    PriceCategoryList::updateOrCreate(['id'=>$request->id],['fulltitle'=>$request->fulltitle,'pricelist'=>$request->pricelist]);
                    break;
                case 'update':
                    $request->validate([
                        'fulltitle' => 'required|unique:price_category_lists,fulltitle,'.$request->id,
                        'pricelist' => 'required|unique:price_category_lists,pricelist,'.$request->id,
                    ], [
                        'fulltitle.required' => 'Price Category is required',
                        'fulltitle.unique' => 'Price Category is already exist',
                        'pricelist.required' => 'Price Category ID is required',
                        'pricelist.unique' => 'Price Category ID is already exist',
                    ]);
                    PriceCategoryList::updateOrCreate(['id'=>$request->id],['fulltitle'=>$request->fulltitle,'pricelist'=>$request->pricelist]);
                    break;
                case 'delete':
                    PriceCategoryList::where('id', $request->id)->delete();;
                    break;
                case 'catlistdetails':
                    $data =DB::select("select i.itemdesc,i.itemcode as itemcode2, ifnull(price/100,0) price,ifnull(discount/100,0) discount from ( select pcl.pricelist,pcl.fulltitle,pil.itemcode,price,pil.discount 
                    from price_category_lists as pcl LEFT JOIN price_items_lists as pil on pil.pricelist=pcl.pricelist
                      where pcl.pricelist='".$request->pricelist."') as q right JOIN items as i on i.itemcode=q.itemcode where i.itemclass in ('001') order by i.itemdesc ;"); 
                    break;
                case 'catlistdetailsUpdate':
                    $data = $this->PriceListUpdate($request);
                    break;
                default:
                    $data = PriceCategoryList::with([
                        'PriceItems' => function ($builder) {
                            $builder->select('pricelist', 'price', 'discount', 'itemcode');
                        }, 'PriceItems.items' => function ($builder) {
                            $builder->select('itemdesc', 'itemcode');
                        }])->get();
                    break;
            }

        
        \DB::commit();
        return ['result' => $data];

        } catch (\Exception $e) {
            DB::rollback();
            // return response()->json(['error' => 'something error in data'], 400);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    private function PriceListUpdate($request)
    {
        PriceItemsList::where('pricelist','=',$request->priceID)->update(['price'=>0]);

        $data = $request->items;
        $datas=[];
        foreach($data as $item){
            if(((float)filter_var($item['price'], FILTER_SANITIZE_NUMBER_INT)*1)!=0){
            // $datas[]= ['price1' => $item['price'] ,'price2' =>(float)filter_var($item['price'], FILTER_SANITIZE_NUMBER_INT)*1];
            PriceItemsList::updateOrCreate(['pricelist'=>$request->priceID,'itemcode' =>$item['itemcode2']],['price' =>(float)filter_var($item['price'], FILTER_SANITIZE_NUMBER_INT)*1]);
            }
        }

        PriceItemsList::where('price','=','0')->delete();
        $datas = PriceItemsList::where('pricelist','=',$request->priceID)->get();
        return $datas;
    }

    public function PriceCustomer(Request $request)
    {

        switch ($request->trnmode) {

            case 'custlistdetailsUpdate':
                $data = $this->CustomerUpdate($request);
                break;
            case 'custlistdetails':
                $data =PriceCustomerList::with(['items:itemcode,itemdesc'])
                ->whereRaw("IF('".$request->custno."'='',''='',price_customer_lists.custno='".$request->custno."')")
                    // ->where('custno', '!=', '')
                    ->get();
                break;
            default:

            break;

        }
        return ['result' => $data];
    }
    private function CustomerUpdate($request)
    { 
        $val = [];
        PriceCustomerList::where('custno','=',$request->items[0]['custno'])->update(['price'=>0,'unitprice'=>0]);
        foreach ($request->items as $data) { 
            PriceCustomerList::updateOrCreate(
                ['branch' => $data['branch'],'custno' =>  $data['custno'],  'itemcode' => $data['itemcode'],],
                ['price' => (float)str_replace(',','',$data['price'])*100,
                'discount' => (float)str_replace(',','',$data['discount'])*100,
                'discount2' => (float)str_replace(',','',$data['discount2'])*100,
                'discount3' => (float)str_replace(',','',$data['discount3'])*100,
                'discount4' => (float)str_replace(',','',$data['discount4'])*100,
                'discount5' => (float)str_replace(',','',$data['discount5'])*100,
                'unitprice' => (float)str_replace(',','',$data['unitprice'])*100,]
            );
        } 
        $data = PriceCustomerList::where('custno',$request->items[0]['custno'])->where('price','=',0)->delete();
        return 'successfull';
    }
}
