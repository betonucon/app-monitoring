<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Customer;
use App\Models\Accesstoken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class CustomerController extends BaseController
{
    public function index(Request $request,$tahun=null)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        $query=Customer::query();

        $get=$query->orderBy('Perusahaan','Asc')->paginate(20);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['KD_Customer'] =$o->KD_Customer;
                $cl['Perusahaan'] = $o->Perusahaan;
                $cl['Alamat'] = $o->Alamat;
                $cl['Kota'] = $o->Kota;
                $sub=$cl;  
                
            $col[]=$sub;
        }
        $success['total_page'] =  ceil($cek/10);
        $success['total_item'] =  $cek;
        $success['current_page'] =  $page;
        $success['result'] =  $col;
        
        

        return $this->sendResponse($success, 'success');
    }

    public function customer_first(Request $request)
    {
       
        $query=Customer::query();

        $o=$query->where('KD_Customer',$request->KD_Customer)->first();
        $cek=$query->count();
        $success=[];
        $success['KD_Customer'] =$o->KD_Customer;
        $success['Perusahaan'] = $o->Perusahaan;
        $success['Alamat'] = $o->Alamat;
        $success['Kota'] = $o->Kota; 
            
        
        

        return $this->sendResponse($success, 'success');
    }

}