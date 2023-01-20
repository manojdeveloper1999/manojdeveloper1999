<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExcelOperation;
use App\Exports\LibraryExport;
use App\Imports\LibraryImport;
use DB;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    protected $storeHash;
    public function __construct()
    {
        $this->store_hash = config('bigcommerce.bc_local_store_hash');
    }
    public function index(){
        $max_order_id = DB::Select("select max(order_id) as max_order_id from order_custom_table");
        $max_id = $max_order_id[0]->max_order_id;
        return view('excel/importExport',['max_id' => $max_id]);
    }
    public function importExport()
    {   
        $total_order_count = DB::Select("select count(*) as total_order_count from order_custom_table");
        $pending_order_count = DB::Select("select count(*) as pending_order_count from order_custom_table where importStatus='pending'");
        $complete_order_count = DB::Select("select count(*) as complete_order_count from order_custom_table where importStatus='completed'");
      
        $max_order_id = DB::Select("select max(order_id) as max_order_id from order_custom_table");
        $max_id = $max_order_id[0]->max_order_id;
        return view('excel/importExport',['max_id' => $max_id,'total_order_count'=>$total_order_count,'pending_order_count'=>$pending_order_count,'complete_order_count'=>$complete_order_count]);
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadExcel($type)
    {
        return Excel::download(new LibraryExport, 'Order_Export_'.now().'.csv');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);
        
        Excel::import(new LibraryImport,request()->file('import_file'));
           
        return back()->with('success', 'Imported CSV record successfully.');
    }
  
    public function generateProductURL()
    {
        $pending_data = DB::Select("select order_id from order_custom_table where importStatus='pending'");
        $order_count = 0;
        $success_count = 0;
        $error_count = 0;
        $error_order_id = '';
        $error_array = array();
        foreach($pending_data as $data){
            $order_id = $data->order_id;
            $url = "https://api.bigcommerce.com/".$this->store_hash."/v2/orders/".$data->order_id."/products";
            $order_count = $order_count + 1;
            $product_arr = array();
            $product_info = $this->GetApi($url);
           
            if($product_info['status'] == '200' && isset($product_info['response'][0]->id)){
                $product_data = $product_info['response'];
                if(count($product_data) > 0){
                    foreach($product_data as $p_data){
                        array_push($product_arr, $p_data->product_id);
                    }
                    $url_data = urlencode(implode(",",$product_arr));
                    $product_api_url = "https://api.bigcommerce.com/".$this->store_hash."/v3/catalog/products?id%3Ain=".$url_data;
                    $get_url_data = $this->GetApi($product_api_url);
                    $ur_arr = array();
                   
                    if($get_url_data['status'] == '200' && isset($get_url_data['response']->data)){
                        $url_data = $get_url_data['response']->data;  
                        foreach($url_data as $u_data){
                           $product_url = $u_data->custom_url->url;
                           $product_id = $u_data->id;
                           $u_data_str = "$product_id : $product_url";
                           array_push($ur_arr, $u_data_str);
                        }
                        $ins_url_data =  implode(" | ",$ur_arr);
                        $insert_url = DB::table('order_custom_table')->where('order_id', $order_id)->limit(1) ->update(array('order_product_url' => $ins_url_data,'importStatus'=>'completed')); 
                        if($insert_url == '1'){
                            $success_count = $success_count + 1;
                        }else{
                            $error_count = $error_count + 1;
                            array_push($error_array,$order_id);
                        }
        
                    } else{
                        $error_count = $error_count + 1;
                        array_push($error_array,$order_id);
                    }
                }else{
                    $error_count = $error_count + 1; 
                    array_push($error_array,$order_id);
                }
            }else{
                $error_count = $error_count + 1;
                array_push($error_array,$order_id);
            }     
        }
        if(count($error_array) > 0){
            $error_order_id = implode(",",$error_array);
           
            DB::table('error_log')->insert(
                ['uploaded_time' => now(), 'issue_order_id' =>$error_order_id]
            );
            DB::table("order_custom_table")->whereIn('order_id',explode(",",$error_order_id))->delete();
        }
       
        $success_status_count = array('processed_count'=>$order_count,'success_count'=>$success_count,'error_count'=>$error_count);
        if($order_count == $success_count){
            return Redirect::to('/')->with(['success'=>'Product URL generated successfully.','processed_count'=>$order_count,'success_count'=>$success_count,'error_count'=>$error_count]);
        }else if($error_count == $order_count){
            return Redirect::to('/')->with(['g-error'=>'Some row contains error data. Please check the CSV and reupload it...!!!','processed_count'=>$order_count,'success_count'=>$success_count,'error_count'=>$error_count,'error_order_id'=>$error_order_id]);
        }else{
            return Redirect::to('/')->with(['g-error'=>'Some row contains error data. Please check the CSV and reupload it...!!!','processed_count'=>$order_count,'success_count'=>$success_count,'error_count'=>$error_count,'error_order_id'=>$error_order_id]);
        }
    }
    public function GetApi($url){
        $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json",
                "X-Auth-Token: 6zlxdrl1p8s5ztrf4n26b9uyjw8qw07"
            ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return array('status'=>'error');
            } else {
                return array('response'=>json_decode($response),'status'=>'200');
            }
    }
   
}
