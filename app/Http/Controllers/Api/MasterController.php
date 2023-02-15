<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Mdivisi;
use App\Models\Accesstoken;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Testapi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class MasterController extends BaseController
{
    public function provinsi(request $request)
    {
        
        $query=Provinsi::query();
        if($request->Nama_Propinsi!=""){
            $get=$query->where('Nama_Propinsi',$request->Nama_Propinsi);
        }
        $get=$query->where('Editke',1)->orderBy('Nama_Propinsi','Asc')->get();
        $cek=$query->count();
        
        $success=[];
        foreach($get as $o){
            $suc=[];
                $suc['Kd_Propinsi'] =$o->Kd_Propinsi;
                $suc['Nama_Propinsi'] = $o->Nama_Propinsi;
            $success[]=$suc;    
        }
        
        
        

        return $this->sendResponse($success, 'success');
    }

    public function save_data_api(request $request)
    {
        try{
            $post=json_decode(file_get_contents('php://input'));
            foreach($post as $no=>$item){
                $data=Testapi::create([
                    'TLGNAME'=>$item->TLGNAME,
                    'TLGID'=>$item->TLGID,
                ]);
            }
            $count=count($post).' Data';
            return $this->sendResponse($count, 'success');
        } catch(\Exception $e){
            return $this->sendResponseerror($e->getMessage());
        } 
    }

    

    public function kota(request $request,$Kd_Propinsi=null)
    {
        
        $query=Kota::query();
        $get=$query->where('kd_propinsi',$Kd_Propinsi);
        $get=$query->orderBy('Nama_Kabupaten','Asc')->get();
        $success=[];
        foreach($get as $o){
            $suc=[];
                $suc['Kd_Kabupaten'] =$o->Kd_Kabupaten;
                $suc['Nama_Kabupaten'] = $o->Nama_Kabupaten;
            $success[]=$suc;    
        }
        

        return $this->sendResponse($success, 'success');
    }

    public function kecamatan(request $request,$Kd_Kabupaten=null)
    {
        
        $query=Kecamatan::query();
        $get=$query->where('Kd_Kabupaten',$Kd_Kabupaten);
        $get=$query->orderBy('Nama_Kecamatan','Asc')->get();
        $success=[];
        foreach($get as $o){
            $suc=[];
                $suc['Kd_Kecamatan'] =$o->Kd_Kecamatan;
                $suc['Nama_Kecamatan'] = $o->Nama_Kecamatan;
            $success[]=$suc;    
        }
        

        return $this->sendResponse($success, 'success');
    }
    public function kelurahan(request $request,$Kd_Kecamatan=null)
    {
        
        $query=Kelurahan::query();
        $get=$query->where('Kd_Kecamatan',$Kd_Kecamatan);
        $get=$query->orderBy('Nama_Kelurahan','Asc')->get();
        $success=[];
        foreach($get as $o){
            $suc=[];
                $suc['Kd_Kelurahan'] =$o->Kd_Kelurahan;
                $suc['Nama_Kelurahan'] = $o->Nama_Kelurahan;
            $success[]=$suc;    
        }
        

        return $this->sendResponse($success, 'success');
    }

    public function kategori_produk(request $request)
    {
        
        $query=Mdivisi::query();
        $get=$query->whereIn('KD_Divisi',array('ATK','NP','PL'));
        $get=$query->orderBy('KD_Divisi','Asc')->get();
        $success=[];
        foreach($get as $o){
            $suc=[];
                $suc['KD_Divisi'] =$o->KD_Divisi;
                $suc['kategori_produk'] = $o->Nama_Divisi;
                $suc['icon'] = url_plug().'/img/'.$o->icon;
            $success[]=$suc;    
        }
        

        return $this->sendResponse($success, 'success');
    }

}