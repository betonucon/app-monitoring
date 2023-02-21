<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\ViewEmploye;
use App\Models\ViewLog;
use App\Models\Viewrole;
use App\Models\Viewstatus;
use App\Models\Role;
use App\Models\HeaderProject;
use App\Models\ViewHeaderProject;
use App\Models\ProjectMaterial;
use App\Models\ViewProjectMaterial;
use App\Models\Material;
use App\Models\LogPengajuan;
use App\Models\ViewCost;
use App\Models\User;

class ProjectController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        if(Auth::user()->role_id==6){
            return view('project.index',compact('template'));
        }
        elseif(Auth::user()->role_id==4){
            return view('project.index_komersil',compact('template'));
        }elseif(Auth::user()->role_id==5){
            return view('project.index_procurement',compact('template'));
        }elseif(Auth::user()->role_id==2){
            return view('project.index_komersil',compact('template'));
        }elseif(Auth::user()->role_id==3){
            return view('project.index_komersil',compact('template'));
        }else{
            return view('error');
        }
        
    }

    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewHeaderProject::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        if(Auth::user()->role_id==6){
            if($data->status_id==1){
                
            }else{
                if($id==0){
                    return view('project.view_data',compact('template','data','disabled','id'));
                }else{
                    return view('project.view',compact('template','data','disabled','id'));
                }
                
            }
        }
        if(Auth::user()->role_id==4){
            if($data->status_id==2){
                return view('project.view_proses',compact('template','data','disabled','id'));
            }else{
                return view('project.view',compact('template','data','disabled','id'));
                
            }
        }
        if(Auth::user()->role_id==5){
            if($data->status_id==3){
                return view('project.view_procurement',compact('template','data','disabled','id'));
            }else{
                return view('project.view',compact('template','data','disabled','id'));
                
            }
        }
       
    }

    public function form_send(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewHeaderProject::where('id',$id)->first();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('project.form_send',compact('template','data','disabled','id'));
    }

    public function tampil_material(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewHeaderProject::where('id',$id)->first();
        $total=ViewProjectMaterial::where('project_header_id',$id)->sum('total');
        $getdata=ViewProjectMaterial::where('project_header_id',$id)->get();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('project.tampil_material',compact('template','data','disabled','id','getdata','total'));
    }


    public function timeline(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewHeaderProject::where('id',$id)->first();
        $getlog=ViewLog::where('project_header_id',$id)->orderBy('id','Desc')->get();
        
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('project.timeline',compact('template','data','disabled','id','getlog'));
    }
   

    public function get_data(request $request)
    {
        error_reporting(0);
        $query = ViewHeaderProject::query();
        if($request->hide==1){
            $data = $query->where('active',0);
        }else{
            $data = $query->where('active',1);
        }
        
        if(Auth::user()->role_id==6){
            if($request->status_id!=""){
                $data = $query->where('status_id',$request->status_id);
            }else{
                
            }
        }
        if(Auth::user()->role_id==4){
            if($request->status_id!=""){
                $data = $query->where('status_id',$request->status_id);
            }else{
                $data = $query->where('status_id','>',1);
            }
            
        }
        if(Auth::user()->role_id==5){
            if($request->status_id!=""){
                $data = $query->where('status_id',$request->status_id);
            }else{
                $data = $query->where('status_id','>',2);
            }
        }
        if(Auth::user()->role_id==2){
            if($request->status_id!=""){
                $data = $query->where('status_id',$request->status_id);
            }else{
                $data = $query->where('status_id','>',1);
            }
        }
        if(Auth::user()->role_id==3){
            if($request->status_id!=""){
                $data = $query->where('status_id',$request->status_id);
            }else{
                $data = $query->where('status_id','>',1);
            }
        }
        if(Auth::user()->role_id==7){
            if($request->status_id!=""){
                $data = $query->where('status_id',$request->status_id);
            }else{
                $data = $query->where('status_id','>',1);
            }
        }
        if(Auth::user()->role_id==8){
            if($request->status_id!=""){
                $data = $query->where('status_id',$request->status_id);
            }else{
                $data = $query->where('status_id','>',1);
            }
        }
        $data = $query->orderBy('id','Desc')->get();

        return Datatables::of($data)
            ->addColumn('action', function ($row) {
                if($row->active==1){
                    
                        $btn='
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Act <i class="fa fa-sort-desc"></i> 
                                </button>
                                <ul class="dropdown-menu">';
                                    if($row->status_id==1){
                                        $btn.='
                                        <li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($row->id).'`)">View</a></li>
                                        <li><a href="javascript:;"  onclick="send_data(`'.encoder($row->id).'`,`0`)">Send Komersil</a></li>
                                        <li><a href="javascript:;"  onclick="delete_data(`'.encoder($row->id).'`,`0`)">Hidden</a></li>
                                        ';
                                    }else{
                                        $btn.=tombol_act($row->id,$row->status_id);
                                    }
                                    $btn.='
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
            ->addColumn('file', function ($row) {
                $btn='<span class="btn btn-success btn-xs" onclick="show_file(`'.$row->file_kontrak.'`)" title="file kontrak"><i class="fa fa-clone"></i></span>';
                return $btn;
            })
            ->addColumn('timeline', function ($row) {
                $btn='<span class="btn btn-warning btn-xs" onclick="show_timeline(`'.encoder($row->id).'`)" title="Log Aktifitas"><i class="fa fa-history"></i></span>';
                return $btn;
            })
            ->addColumn('status_now', function ($row) {
                $btn='<font color="'.$row->color.'" style="font-style:italic">'.$row->singkatan.'</font>';
                return $btn;
            })
            
            ->rawColumns(['action','status_now','file','timeline'])
            ->make(true);
    }
    public function getdatamaterial(request $request)
    {
        error_reporting(0);
        $query = ProjectMaterial::query();
        $data = $query->where('project_header_id',$request->id);
        $data = $query->orderBy('id','Desc')->get();

        return Datatables::of($data)
            ->addColumn('action', function ($row) {
                
                $btn='
                   <span class="btn btn-danger btn-xs" onclick="delete_material(`'.encoder($row->id).'`)"><i class="fa fa-close"></i></span>
                ';
                   
               
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }

    public function get_status_data(request $request)
    {
        error_reporting(0);
        $query = Viewstatus::query();
        // if($request->KD_Divisi!=""){
        //     $data = $query->where('kd_divisi',$request->KD_Divisi);
        // }
        $data = $query->orderBy('id','Asc')->get();
        $success=[];
        foreach($data as $o){
            $btn='
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box" style="margin-bottom: 5px; min-height: 50px;">
                        <span class="info-box-iconic bg-'.$o->color.'" style="margin-bottom: 1px; min-height: 50px;"><i class="fa fa-pie-chart"></i></span>
        
                        <div class="info-box-content" style="padding: 5px 10px; margin-left: 50px;">
                            <span class="info-box-text" style="text-transform:capitalize;font-size:14px">'.$o->singkatan.'</span>
                            <span class="info-box-number" style="font-weight:bold;font-size:12px">'.$o->total.'<small></small></span>
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
    public function total_item(request $request)
    {
        $id=decoder($request->id);
        
        $data=ProjectMaterial::where('project_header_id',$id)->count();
        $sum=ProjectMaterial::where('project_header_id',$id)->sum('qty');
        $dtr='  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Total Item</label>

                    <div class="col-sm-6">
                    <input type="text" name="total_item" class="form-control input-sm" id="total_item"  value="'.$data.'" placeholder="Ketik...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Total Qty</label>

                    <div class="col-sm-6">
                    <input type="text" name="total_item" class="form-control input-sm" id="total_item"  value="'.$sum.'" placeholder="Ketik...">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label"></label>

                    <div class="col-sm-6">
                    &nbsp;
                    </div>
                </div>';
        return $dtr;
    }


    public function total_qty(request $request)
    {
        $id=decoder($request->id);
        
        $data=ProjectMaterial::where('id',$id)->sum('qty');
        return $data;
    }

    public function delete(request $request)
    {
        $id=decoder($request->id);
        
        $data=HeaderProject::where('id',$id)->update(['active'=>$request->act]);
    }

    public function delete_material(request $request)
    {
        $id=decoder($request->id);
        
        $data=ProjectMaterial::where('id',$id)->delete();
    }
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        if($request->id=='0'){
            $rules['cost']= 'required';
            $messages['cost.required']= 'Pilih header cost ';
            
            $rules['customer_code']= 'required';
            $messages['customer_code.required']= 'Pilih header customer ';
            
            $rules['file']= 'required|mimes:pdf';
            $messages['file.required']= 'Upload file kontrak';
        }else{
            if($request->file!=""){
                $rules['file']= 'required|mimes:pdf';
                $messages['file.required']= 'Upload file kontrak';
            }
        }
        
        $rules['deskripsi_project']= 'required';
        $messages['deskripsi_project.required']= 'Masukan deskripsi kontrak';
        
        $rules['start_date']= 'required';
        $messages['start_date.required']= 'Masukan start date kontrak';

        $rules['end_date']= 'required';
        $messages['end_date.required']= 'Masukan end date kontrak';
        
        
        
        $rules['nilai']= 'required|min:0|not_in:0';
        $messages['nilai.required']= 'Masukan nilai kontrak';
        $messages['nilai.not_in']= 'Masukan nilai kontrak';
        
        $rules['terbilang']= 'required';
        $messages['terbilang.required']= 'Masukan terbilang';

       
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
                $penomoran=penomoran_cost_center($request->cost);
                $cek=HeaderProject::where('cost_center',$penomoran)->count();
                if($cek>0){
                    echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Cost Center '.test_penomoran_cost_center($request->cost).' sudah terdaftar</div>';
                }else{
                    
                    $thumbnail = $request->file;
                    $thumbnailFileName =$penomoran.'-'.date('ymdhis').'.'.$thumbnail->getClientOriginalExtension();
                    $thumbnailPath =$thumbnailFileName;

                    $file =\Storage::disk('public_uploads');
                    if($file->put($thumbnailPath, file_get_contents($thumbnail))){
                        $data=HeaderProject::create([
                            'cost'=>$request->cost,
                            'cost_center'=>$penomoran,
                            'customer_code'=>$request->cost,
                            'deskripsi_project'=>$request->deskripsi_project,
                            'start_date'=>$request->start_date,
                            'end_date'=>$request->end_date,
                            'username'=>Auth::user()->username,
                            'terbilang'=>$request->terbilang,
                            'nilai'=>ubah_uang($request->nilai),
                            'file_kontrak'=>$thumbnailPath,
                            'active'=>1,
                            'status_id'=>1,
                            'create'=>date('Y-m-d H:i:s'),
                        ]);

                        $log=LogPengajuan::create([
                            'cost_center'=>$penomoran,
                            'project_header_id'=>$data->id,
                            'deskripsi'=>'Pengajuan baru dengan cost center '.$penomoran,
                            'status_id'=>1,
                            'nik'=>Auth::user()->username,
                            'role_id'=>Auth::user()->role_id,
                            'revisi'=>1,
                            'created_at'=>date('Y-m-d H:i:s'),
                        ]);
                        echo'@ok';
                    }
                }
            }else{
                $mst=HeaderProject::where('id',$request->id)->first();
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'deskripsi_project'=>$request->deskripsi_project,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date,
                    'username'=>Auth::user()->username,
                    'terbilang'=>$request->terbilang,
                    'nilai'=>ubah_uang($request->nilai),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                $log=LogPengajuan::create([
                    'cost_center'=>$mst['cost_center'],
                    'project_header_id'=>$request->id,
                    'deskripsi'=>'Perubahan cost center '.$mst['cost_center'],
                    'status_id'=>1,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                if($request->file!=""){
                    $thumbnail = $request->file;
                    $thumbnailFileName =$mst['cost_center'].'.'.$thumbnail->getClientOriginalExtension();
                    $thumbnailPath =$thumbnailFileName;

                    $file =\Storage::disk('public_uploads');
                    if($file->put($thumbnailPath, file_get_contents($thumbnail))){
                        $data=HeaderProject::UpdateOrcreate([
                            'id'=>$request->id,
                        ],[
                            'file_kontrak'=>$thumbnailPath,
                            'username'=>Auth::user()->username,
                        ]);
                        echo'@ok';
                    }
                }else{
                    
                    echo'@ok';
                }
                
            }
           
        }
    }

    public function kirim_komersil(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['nik']= 'required';
        $messages['nik.required']= 'Pilih petugas dari div komersil';
        
        $rules['catatan']= 'required';
        $messages['catatan.required']= 'Masukan catatan';


       
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
            
                $mst=HeaderProject::where('id',$request->id)->first();
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_id'=>(((int)$mst->status_id)+1),
                    'nik_komersil'=>$request->nik,
                    'tgl_send_komersil'=>date('Y-m-d H:i:s'),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                $log=LogPengajuan::create([
                    'cost_center'=>$mst['cost_center'],
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$request->catatan,
                    'status_id'=>(((int)$mst->status_id)+1),
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
               
           
        }
        
    }

    public function kembali_komersil(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['catatan']= 'required';
        $messages['catatan.required']= 'Masukan catatan';


       
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
            
                $mst=HeaderProject::where('id',$request->id)->first();
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_id'=>(((int)$mst->status_id)-1),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                $log=LogPengajuan::create([
                    'cost_center'=>$mst['cost_center'],
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$request->catatan,
                    'status_id'=>(((int)$mst->status_id)-1),
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>2,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
               
           
        }
        
    }

    public function kirim_procurement(request $request){
        error_reporting(0);
        
            
            $count=ProjectMaterial::where('project_header_id',$request->id)->count();
            if($count>0){
                $mst=HeaderProject::where('id',$request->id)->first();
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_id'=>(((int)$mst->status_id)+1),
                    'tgl_send_procurement'=>date('Y-m-d H:i:s'),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                $log=LogPengajuan::create([
                    'cost_center'=>$mst['cost_center'],
                    'project_header_id'=>$request->id,
                    'deskripsi'=>'Selesai dikonfirmasi oleh petugas komersil dan dikirim ke procurement',
                    'status_id'=>(((int)$mst->status_id)+1),
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
            }else{
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                echo'-Lengakapi material yang dibutuhkah';
                echo'</div></div>';
            }
               
        
        
    }

    public function store_material(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['kode_material']= 'required';
        $messages['kode_material.required']= 'Pilih material';
        
        $rules['qty']= 'required';
        $messages['qty.required']= 'Masukan qty';


       
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
            
                $mst=Material::where('kode_material',$request->kode_material)->first();
                $data=ProjectMaterial::UpdateOrcreate([
                    'kode_material'=>$request->kode_material,
                    'project_header_id'=>$request->id,
                ],[
                    'qty'=>$request->qty,
                    'nama_material'=>$mst->nama_material,
                    'status_material'=>2,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);

                echo'@ok';
               
           
        }
        
    }
}
