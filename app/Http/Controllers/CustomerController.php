<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\ViewEmploye;
use App\Models\Viewrole;
use App\Models\Role;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\ViewCustomer;
use App\Models\User;

class CustomerController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('customer.index',compact('template'));
    }

    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=Customer::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('customer.view_data',compact('template','data','disabled','id'));
    }
   

    public function delete(request $request)
    {
        $id=decoder($request->id);
        
        $data=Customer::where('id',$id)->update(['active'=>$request->act]);
    }

    public function get_data(request $request)
    {
        error_reporting(0);
        $query = ViewCustomer::query();
        if($request->hide==1){
            $data = $query->where('active',0);
        }else{
            $data = $query->where('active',1);
        }
        $data = $query->orderBy('customer','Asc')->get();

        return Datatables::of($data)
            ->addColumn('seleksi', function ($row) {
                $btn='<span class="btn btn-success btn-xs" onclick="pilih_customer(`'.$row->customer_code.'`,`'.$row->customer.'`)">Pilih</span>';
                return $btn;
            })
            ->addColumn('seleksi_kontrak', function ($row) {
                $btn='<span class="btn btn-success btn-xs" onclick="pilih_customer(`'.$row->customer_code.'`,`'.$row->customer.'`,`'.$row->cost.'`,`'.penomoran_cost_center($row->customer_code).'`)">Pilih</span>';
                return $btn;
            })
            ->addColumn('action', function ($row) {
                if($row->active==1){
                    $btn='
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Act <i class="fa fa-sort-desc"></i> 
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:;" onclick="location.assign(`'.url('customer/view').'?id='.encoder($row->id).'`)">View</a></li>
                                <li><a href="javascript:;"  onclick="delete_data(`'.encoder($row->id).'`,`0`)">Hidden</a></li>
                            </ul>
                        </div>
                    ';
                }else{
                    $btn='
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Act <i class="fa fa-sort-desc"></i> 
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:;"  onclick="delete_data(`'.encoder($row->id).'`,1)">Un Hidden</a></li>
                            </ul>
                        </div>
                    ';
                }
                return $btn;
            })
            
            ->rawColumns(['action','seleksi','seleksi_kontrak'])
            ->make(true);
    }

    public function get_role(request $request)
    {
        error_reporting(0);
        $query = Viewrole::query();
        // if($request->KD_Divisi!=""){
        //     $data = $query->where('kd_divisi',$request->KD_Divisi);
        // }
        $data = $query->where('id','!=',1)->orderBy('id','Asc')->get();
        $success=[];
        foreach($data as $o){
            $btn='
                <div class="col-md-2 col-sm-6 col-xs-12">
                    <div class="info-box" style="margin-bottom: 5px; min-height: 50px;">
                        <span class="info-box-iconic bg-'.$o->color.'" style="margin-bottom: 1px; min-height: 50px;"><i class="fa fa-users"></i></span>
        
                        <div class="info-box-content" style="padding: 5px 10px; margin-left: 50px;">
                            <span class="info-box-text">'.$o->role.'</span>
                            <span class="info-box-number">'.$o->total.'<small>"</small></span>
                        </div>
                    </div>
                </div>
            ';
            $scs=[];
            $scs['id']=$o->id;
            $scs['action']=$btn;
            $success[]=$scs;
        }
        return response()->json($success, 200);
    }
    
    
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
       
        $rules['customer']= 'required';
        $messages['customer.required']= 'Masukan customer';
        
        $rules['alamat']= 'required';
        $messages['alamat.required']= 'Masukan area / lokasi project';

       
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{
            if($request->id=='0'){
                
                    $data=Customer::create([
                        'customer_code'=>penomoran_customer(),
                        'singkatan'=>$request->singkatan,
                        'alamat'=>$request->alamat,
                        'active'=>1,
                        'customer'=>$request->customer,
                    ]);
                    echo'@ok';
                
            }else{
                $data=Customer::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'alamat'=>$request->alamat,
                    'customer'=>$request->customer,
                    'singkatan'=>$request->singkatan,
                ]);
                echo'@ok';
            }
           
        }
    }
}
