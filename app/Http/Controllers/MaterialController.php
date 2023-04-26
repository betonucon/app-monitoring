<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\ViewEmploye;
use App\Models\ViewProjectMaterial;
use App\Models\ViewMaterial;
use App\Models\MaterialStok;
use App\Models\ProjectMaterial;
use App\Models\ViewHeaderStok;
use App\Models\Viewrole;
use App\Models\Role;
use App\Models\Customer;
use App\Models\ExampleMaterial;
use App\Models\Material;
use App\Models\User;

class MaterialController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('material.index',compact('template'));
    }
    public function index_masuk(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('material.index_masuk',compact('template'));
    }
    public function index_keluar(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('material.index_keluar',compact('template'));
    }

    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=Material::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('material.view_data',compact('template','data','disabled','id'));
    }
    public function create_stok(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewHeaderStok::where('id',$id)->first();
        
        $cn=ProjectMaterial::where('project_header_id',$id)->where('status',2)->count();
        $count=$cn+1;
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('material.view_data_stok',compact('template','data','count','disabled','id'));
    }
   

    public function delete(request $request)
    {
        $id=decoder($request->id);
        
        $data=Material::where('id',$id)->update(['active'=>$request->act]);
    }
    
    public function delete_stok(request $request)
    {
        $id=decoder($request->id);
        
        $data=MaterialStok::where('id',$id)->delete();
        $sub=ProjectMaterial::where('project_header_id',$id)->where('status',2)->delete();
    }
    public function get_material(){
        $data=ExampleMaterial::orderBy('kategori','Asc')->get();
        
        foreach($data as $no=>$o){
            $material=$o->material.' ('.$o->last_name.')';
            $deskripsi='Spec '.$o->material.' ('.$o->last_name.') '.$o->jenis;
            $data=Material::create([
                
                'kode_material'=>penomoran_material($o->kategori),
                'nama_material'=>$material,
                'deskripsi'=>$deskripsi,
                'kategori_material_id'=>$o->kategori,
                'update'=>date('Y-m-d H:i:s'),
                'active'=>1,
            ]);
        }
    }
    public function get_data(request $request)
    {
        error_reporting(0);
        $query = ViewMaterial::query();
        if($request->hide==1){
            $data = $query->where('active',0);
        }else{
            $data = $query->where('active',1);
        }
        $data = $query->orderBy('nama_material','Asc')->get();

        return Datatables::of($data)
            ->addColumn('seleksi', function ($row) {
                $btn='<span class="btn btn-success btn-xs" onclick="pilih_material(`'.$row->kode_material.'`,`'.$row->nama_material.'`,`'.$row->harga.'`,'.$row->stok.')">Pilih</span>';
                return $btn;
            })
            ->addColumn('stok', function ($row) {
                if($row->stok_keluar>$row->stok_masuk){
                    return '<font color="red">'.($row->stok_masuk-$row->stok_keluar).'</font>';
                }else{
                    return '<font color="#000">'.($row->stok_masuk-$row->stok_keluar).'</font>';
                }
            })
            ->addColumn('action', function ($row) {
                if($row->active==1){
                    $btn='
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Act <i class="fa fa-sort-desc"></i> 
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:;" onclick="location.assign(`'.url('material/view').'?id='.encoder($row->id).'`)">View</a></li>
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
            
            ->rawColumns(['action','seleksi','stok'])
            ->make(true);
    }
    public function get_data_stok(request $request)
    {
        error_reporting(0);
        $query = ViewHeaderStok::query();
        $data = $query->orderBy('id','Desc')->get();

        return Datatables::of($data)
            ->addColumn('action', function ($row) {
               
                    $btn='
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Act <i class="fa fa-sort-desc"></i> 
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:;" onclick="location.assign(`'.url('material/create_stok').'?id='.encoder($row->id).'`)">View</a></li>
                                <li><a href="javascript:;"  onclick="delete_data(`'.encoder($row->id).'`,`0`)">Hidden</a></li>
                            </ul>
                        </div>
                    ';
                
                return $btn;
            })
            
            ->rawColumns(['action','seleksi','stok'])
            ->make(true);
    }

    public function get_data_event(request $request)
    {
        error_reporting(0);
        $query = ViewProjectMaterial::query();
        $data = $query->where('status_material',$request->status)->orderBy('created_at','Asc')->get();

        return Datatables::of($data)
            ->addColumn('action', function ($row) {
                if($row->active==1){
                    $btn='
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Act <i class="fa fa-sort-desc"></i> 
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:;" onclick="location.assign(`'.url('material/view').'?id='.encoder($row->id).'`)">View</a></li>
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
            $rules['kode_material']= 'required';
            $messages['kode_material.required']= 'Masukan kode_material';
        }
        
        $rules['nama_material']= 'required';
        $messages['nama_material.required']= 'Masukan nama material';

        $rules['harga']= 'required|min:0|not_in:0';
        $messages['harga.required']= 'Masukan harga kontrak';
        $messages['harga.not_in']= 'Masukan harga kontrak';
       
        $rules['satuan']= 'required';
        $messages['satuan.required']= 'Masukan nama satuan';

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
                $cek=Material::where('kode_material',$request->kode_material)->count();
                if($cek>0){
                    echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Kode material sudah terdaftar</div>';
                }else{
                    $data=Material::create([
                        'kode_material'=>$request->kode_material,
                        'nama_material'=>$request->nama_material,
                        'satuan'=>$request->satuan,
                        'harga'=>ubah_uang($request->harga),
                        'update'=>date('Y-m-d H:i:s'),
                        'active'=>1,
                    ]);
                    echo'@ok';
                }
            }else{
                $data=Material::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'nama_material'=>$request->nama_material,
                    'satuan'=>$request->satuan,
                    'harga'=>ubah_uang($request->harga),
                    'update'=>date('Y-m-d H:i:s')
                ]);
                echo'@ok';
            }
           
        }
    }

    public function store_stok(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        if($request->id=='0'){
            $rules['kategori_stok_id']= 'required';
            $messages['kategori_stok_id.required']= 'Masukan sumber kategori';
        }
        if($request->kategori_stok_id==2){
            $rules['cost_center']= 'required';
            $messages['cost_center.required']= 'Masukan cost center project';
        }
        
        $rules['tanggal']= 'required';
        $messages['tanggal.required']= 'Masukan tanggal proses';


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
            $count=(int) count($request->kode_material);
            if($request->id=='0'){
                if($request->kategori_stok_id==2){
                    $cost_center=$request->cost_center;
                }else{
                    $cost_center='00000';
                }
                
                if($count>0){
                    $cek=0;
                    for($x=0;$x<$count;$x++){
                        if($request->kode_material[$x]==""  || $request->biaya[$x]=="" || $request->qty[$x]==""   || $request->total[$x]=="" || $request->total[$x]==0){
                            $cek+=0;
                        }else{
                            $cek+=1;
                        }
                    }

                    if($cek==$count){
                        $data=MaterialStok::create([
                            'kategori_stok_id'=>$request->kategori_stok_id,
                            'cost_center'=>$cost_center,
                            'tanggal'=>$request->tanggal,
                            'customer_code'=>$request->customer_code,
                            'created_at'=>date('Y-m-d H:i:s'),
                        ]);
                        for($x=0;$x<$count;$x++){
                        
                            $data=ProjectMaterial::UpdateOrcreate([
                                'project_header_id'=>$data->id,
                                'kode_material'=>$request->kode_material[$x],
                                'status'=>2,
                                
                            ],[
                                'biaya'=>ubah_uang($request->biaya[$x]),
                                'qty'=>ubah_uang($request->qty[$x]),
                                'total'=>ubah_uang($request->total[$x]),
                                'stok'=>0,
                                'status_material_id'=>3,
                                'nama_material'=>$request->nama_material[$x],
                                'created_at'=>date('Y-m-d H:i:s'),
                            ]);
                        
                        }
                        echo'@ok';
                    }else{
                        echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Lengkapi semua kolom</div></div>';
                    }
                }else{
                    echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Lengkapi semua kolom</div></div>';
                }
                
            }else{
                

                if($count>0){
                    $cek=0;
                    for($x=0;$x<$count;$x++){
                        if($request->kode_material[$x]==""  || $request->biaya[$x]=="" || $request->qty[$x]==""   || $request->total[$x]=="" || $request->total[$x]==0){
                            $cek+=0;
                        }else{
                            $cek+=1;
                        }
                    }

                    if($cek==$count){
                        $data=MaterialStok::UpdateOrcreate([
                            'id'=>$request->id,
                        ],[
                            'tanggal'=>$request->tanggal,
                            'created_at'=>date('Y-m-d H:i:s')
                        ]);
                        for($x=0;$x<$count;$x++){
                        
                            $data=ProjectMaterial::UpdateOrcreate([
                                'project_header_id'=>$data->id,
                                'kode_material'=>$request->kode_material[$x],
                                'status'=>2,
                                
                            ],[
                                'biaya'=>ubah_uang($request->biaya[$x]),
                                'qty'=>ubah_uang($request->qty[$x]),
                                'total'=>ubah_uang($request->total[$x]),
                                'stok'=>0,
                                'status_material_id'=>3,
                                'nama_material'=>$request->nama_material[$x],
                                'created_at'=>date('Y-m-d H:i:s'),
                            ]);
                        
                        }
                        echo'@ok';
                    }else{
                        echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Lengkapi semua kolom</div></div>';
                    }
                }else{
                    $data=MaterialStok::UpdateOrcreate([
                        'id'=>$request->id,
                    ],[
                        'tanggal'=>$request->tanggal,
                        'created_at'=>date('Y-m-d H:i:s')
                    ]);
                    echo'@ok';
                }
                
            }
           
        }
    }
}
