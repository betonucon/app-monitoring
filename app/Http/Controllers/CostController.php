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
use App\Models\Cost;
use App\Models\ViewCost;
use App\Models\User;

class CostController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('cost.index',compact('template'));
    }

    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=Cost::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('cost.view_data',compact('template','data','disabled','id'));
    }
   

    public function get_data(request $request)
    {
        error_reporting(0);
        $query = ViewCost::query();
        if($request->customer_code!=""){
            $data = $query->where('customer_code',$request->customer_code);
        }
        $data = $query->orderBy('cost','Asc')->get();

        return Datatables::of($data)
            ->addColumn('seleksi', function ($row) {
                $btn='<span class="btn btn-success btn-xs" onclick="pilih_customer(`'.$row->cost.'`,`'.$row->customer_code.'`,`'.$row->customer.'`,`'.$row->area.'`)">Pilih</span>';
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn='
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                         Act <i class="fa fa-sort-desc"></i> 
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" onclick="location.assign(`'.url('cost/view').'?id='.encoder($row->id).'`)">View</a></li>
                            <li><a href="javascript:;">Delete</a></li>
                        </ul>
                    </div>
                ';
                return $btn;
            })
            
            ->rawColumns(['action','seleksi'])
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
        
        if($request->id=='0'){
            $rules['cost']= 'required';
            $messages['cost.required']= 'Masukan cost code';
        }
        
        $rules['area']= 'required';
        $messages['area.required']= 'Masukan area / lokasi project';

       
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
                $cek=Cost::where('cost',$request->cost)->count();
                if($cek>0){
                    echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Cost Code sudah terdaftar</div>';
                }else{
                    $data=Cost::create([
                        'cost'=>$request->cost,
                        'area'=>$request->area,
                        'active'=>1,
                        'customer_code'=>$request->customer_code,
                    ]);
                    echo'@ok';
                }
            }else{
                $data=Cost::UpdateOrcreate([
                    'cost'=>$request->cost,
                ],[
                    'area'=>$request->area,
                    'customer_code'=>$request->customer_code,
                ]);
                echo'@ok';
            }
           
        }
    }
}
