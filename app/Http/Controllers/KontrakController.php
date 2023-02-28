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
use App\Models\ProjectPersonal;
use App\Models\ProjectOperasional;
use App\Models\ViewProjectMaterial;
use App\Models\ProjectRisiko;
use App\Models\ProjectPeriode;
use App\Models\ProjectAnggaranperiode;
use App\Models\Material;
use App\Models\LogPengajuan;
use App\Models\ViewCost;
use App\Models\User;

class KontrakController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        if(Auth::user()->role_id==6){
            return view('kontrak.index',compact('template'));
        }
        elseif(Auth::user()->role_id==4){
            return view('kontrak.index_komersil',compact('template'));
        }elseif(Auth::user()->role_id==7){
            return view('kontrak.index_operasional',compact('template'));
        }elseif(Auth::user()->role_id==5){
            return view('kontrak.index_procurement',compact('template'));
        }elseif(Auth::user()->role_id==2){
            return view('kontrak.index_direktur_operasional',compact('template'));
        }elseif(Auth::user()->role_id==3){
            return view('kontrak.index_mgr_operasional',compact('template'));
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
            $nom=1;
            $nomper=1;
        }else{
            $disabled='readonly';
            $connomor=ProjectPersonal::where('project_header_id',$id)->count();
            $connomoropr=ProjectOperasional::where('project_header_id',$id)->count();
            $nom=($connomor+1);
            $nomper=($connomoropr+1);
        }
        if(Auth::user()->role_id==6){
            if($data->status_id==8){
                return view('kontrak.view_data',compact('template','data','disabled','id','nom','nomper'));
            }else{
               
                    if($data->status_id==6){
                        return view('kontrak.view_bidding',compact('template','data','disabled','nom','nomper'));
                    }else{
                        return view('kontrak.view',compact('template','data','disabled','nom','nomper'));
                    }
                    
               
            }
        }
        if(Auth::user()->role_id==4){
            if($data->status_id==2){
                return view('kontrak.view_approve_komersil',compact('template','data','disabled','nom','nomper'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','nom','nomper'));
                
            }
        }
        if(Auth::user()->role_id==7){
            if($data->status_id==10){
                return view('kontrak.view_approve_operasional',compact('template','data','disabled','nom','nomper'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','nom','nomper'));
                
            }
        }
        if(Auth::user()->role_id==3){
            if($data->status_id==4){
                return view('kontrak.view_approve_mgr_operasional',compact('template','data','disabled','nom','nomper'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','nom','nomper'));
                
            }
        }
        if(Auth::user()->role_id==2){
            if($data->status_id==5){
                return view('kontrak.view_approve_direktur_operasional',compact('template','data','disabled','nom','nomper'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','nom','nomper'));
                
            }
        }
        if(Auth::user()->role_id==5){
            if($data->status_id==3){
                return view('kontrak.view_procurement',compact('template','data','disabled','nom','nomper'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','nom','nomper'));
                
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
        return view('kontrak.form_send',compact('template','data','disabled','id'));
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
        return view('kontrak.tampil_material',compact('template','data','disabled','id','getdata','total'));
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
        return view('kontrak.timeline',compact('template','data','disabled','id','getlog'));
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
                $data = $query->where('status_id','>',7);
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
                $data = $query->where('status_id','>',4);
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
                $data = $query->where('status_id','>',2);
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
                                <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Act <i class="fa fa-sort-desc"></i> 
                                </button>
                                <ul class="dropdown-menu">';
                                    if($row->status_id==1){
                                        $btn.='
                                        <li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($row->id).'`)">View</a></li>
                                        <li><a href="javascript:;"  onclick="send_data_to(`'.encoder($row->id).'`,`0`)">Send Komersil</a></li>
                                        <li><a href="javascript:;"  onclick="delete_data(`'.encoder($row->id).'`,`0`)">Hidden</a></li>
                                        ';
                                    }else{
                                        $btn.=tombol_kontrak_act($row->id,$row->status_id);
                                    }
                                    $btn.='
                                </ul>
                            </div>
                        ';
                   
                }else{
                    $btn='
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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
                $btn='<span class="btn btn-success btn-xs" onclick="show_timeline(`'.encoder($row->id).'`)" title="Log Aktifitas"><i class="fa fa-history"></i></span>';
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

    public function tampil_personal(request $request)
    {
        $act='';
        foreach(get_personal($request->id) as $no=>$o){
            if($request->act==1){
                $act.='
                    <tr style="background:#fff">
                        <td  class="td-detail">'.($no+1).'</td>
                        <td  class="td-detail">'.$o->nik.'</td>
                        <td  class="td-detail">'.$o->nama.'</td>
                        <td  class="td-detail">'.$o->job.'</td>
                        <td  class="td-detail  text-right">'.uang($o->biaya).'</td>
                    </tr>';
            }else{
                $act.='
                    <tr style="background:#fff">
                        <td>'.($no+1).'</td>
                        <td>'.$o->nik.'</td>
                        <td>'.$o->nama.'</td>
                        <td>'.$o->job.'</td>
                        <td class="text-right">'.uang($o->biaya).'</td>
                        <td><span class="btn btn-danger btn-xs" onclick="delete_personal('.$o->id.')"><i class="fa fa-close"></i></span></td>
                    </tr>';
            }
            
        }
        return $act;
    }
    public function tampil_periode(request $request)
    {
        $act='';
        foreach(get_periode($request->id) as $no=>$o){
            $act.='
                <tr>
                    <td class="tdd-detail">'.($no+1).'</td>
                    <td class="tdd-detail">Bulan ke '.($no+1).' ('.bulan($o->bulan).' '.$o->tahun.')</td>
                    <td class="tdd-detail"><span class="btn btn-xs bg-red" onclick="show_personal_periode('.$o->id.')"><i class="fa fa-search"></i></span></td>
                    <td class="tdd-detail  text-right">'.uang($o->personal).'</td>
                    <td class="tdd-detail"><span class="btn btn-xs bg-red" onclick="show_operasional_periode('.$o->id.')"><i class="fa fa-search"></i></span></td>
                    <td class="tdd-detail  text-right">'.uang($o->operasional).'</td>
                </tr>


            ';
            
        }
        return $act;
    }
    public function tampil_personal_periode(request $request)
    {
        $act='
            <input type="hidden" name="project_header_id" value="'.$request->project_header_id.'">
            <input type="hidden" name="project_periode_id" value="'.$request->project_periode_id.'">
            <table class="table table-bordered" id="">
                <thead>
                    <tr style="background:#bcbcc7">
                        <th class="thh-detail" style="width: 5%"></th>
                        <th class="thh-detail" style="width: 14%">NIK</th>
                        <th class="thh-detail">Nama</th>
                        <th class="thh-detail" style="width:20%">Job Project</th>
                        <th class="thh-detail" style="width:14%">Salery</th>
                    </tr>
                </thead>
                <tbody>';
        foreach(get_personal($request->project_header_id) as $no=>$o){
            $cek=ProjectAnggaranperiode::where('biaya_id',$o->id)
                                            ->where('project_header_id',$request->project_header_id)
                                            ->where('project_periode_id',$request->project_periode_id)
                                            ->where('kategori',1)->count();
                if($cek>0){
                    $sel='checked';
                }else{
                    $sel="";
                }
                $act.='
                    <tr style="background:#fff">
                        <td class="tdd-detail"><input type="checkbox" '.$sel.' name="project_personal_id[]" value="'.$o->id.'"></td>
                        <td class="tdd-detail">'.$o->nik.'</td>
                        <td class="tdd-detail">'.$o->nama.'</td>
                        <td class="tdd-detail">'.$o->job.'</td>
                        <td class="tdd-detail  text-right">'.uang($o->biaya).'
                    </tr>';
        }
        $act.='</tbody></table>';
        return $act;
    }
    public function tampil_operasional_periode(request $request)
    {
        $act='
            <input type="hidden" name="project_header_id" value="'.$request->project_header_id.'">
            <input type="hidden" name="project_periode_id" value="'.$request->project_periode_id.'">
            <table class="table table-bordered" id="">
                <thead>
                    <tr style="background:#bcbcc7">
                        <th  class="thh-detail"  style="width: 5%"></th>
                        <th  class="thh-detail" >Keterangan</th>
                        <th  class="thh-detail"  style="width:14%">Salery</th>
                    </tr>
                </thead>
                <tbody>';
        foreach(get_operasional($request->project_header_id) as $no=>$o){
                $cek=ProjectAnggaranperiode::where('biaya_id',$o->id)
                                            ->where('project_header_id',$request->project_header_id)
                                            ->where('project_periode_id',$request->project_periode_id)
                                            ->where('kategori',2)->count();
                if($cek>0){
                    $sel='checked';
                }else{
                    $sel="";
                }
                $act.='
                    <tr style="background:#fff">
                        <td class="tdd-detail"><input type="checkbox" '.$sel.' name="project_operasional_id[]" value="'.$o->id.'"></td>
                        <td class="tdd-detail">'.$o->keterangan.'</td>
                        <td class="tdd-detail text-right">'.uang($o->biaya).'</td>
                    </tr>';
            
        }
        $act.='</tbody></table>';
        return $act;
    }

    public function tampil_operasional(request $request)
    {
        $act='';
        foreach(get_operasional($request->id) as $no=>$o){
            if($request->act==1){
                $act.='
                <tr style="background:#fff">
                    <td class="td-detail">'.($no+1).'</td>
                    <td class="td-detail">'.$o->keterangan.'</td>
                    <td class="td-detail">'.uang($o->biaya).'</td>
                </tr>';
            }else{
                $act.='
                <tr style="background:#fff">
                    <td>'.($no+1).'</td>
                    <td>'.$o->keterangan.'</td>
                    <td class="text-right">'.uang($o->biaya).'</td>
                    <td><span class="btn btn-danger btn-xs" onclick="delete_operasional('.$o->id.')"><i class="fa fa-close"></i></span></td>
                        
                </tr>';
            }
            
        }
        return $act;
    }
    public function tampil_pengeluaran(request $request)
    {   
        $data=HeaderProject::where('id',$request->id)->first();
        if($request->act==1){
            $act='
            <div class="callout callout-info" style="border-color: #fdb593;background-color: #e9e4ca !important; color: #000 !important;">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Nilai Kontrak</label>

                    <div class="col-sm-3">
                        <input type="text"  value="'.uang($data->nilai).'" readonly class="form-control  input-sm" placeholder="0000">
                    </div>
                
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Biaya Personal</label>

                    <div class="col-sm-3">
                        <input type="text"  value="'.uang(sum_personal($data->id)).'" readonly class="form-control  input-sm" placeholder="0000">
                    </div>
                
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Biaya Operasional</label>

                    <div class="col-sm-3">
                        <input type="text"  value="'.uang(sum_operasional($data->id)).'" readonly class="form-control  input-sm" placeholder="0000">
                    </div>
                
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Margin</label>

                    <div class="col-sm-3">
                        <input type="text"  value="'.uang(($data->nilai*$data->margin)/100).' ('.$data->margin.'%)" readonly class="form-control  input-sm" placeholder="0000">
                    </div>
                
                </div>
            </div>
        ';
        }else{
            $act='
                <div class="callout callout-info" style="border-color: #fdb593;background-color: #e9e4ca !important; color: #000 !important;">
                    <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Nilai Kontrak</label>

                    <div class="col-sm-3">
                        <input type="text"  value="'.uang($data->nilai).'" readonly class="form-control  input-sm" placeholder="0000">
                    </div>
                    
                    </div>
                    <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Biaya Personal</label>

                    <div class="col-sm-3">
                        <input type="text"  value="'.uang(sum_personal($data->id)).'" readonly class="form-control  input-sm" placeholder="0000">
                    </div>
                    
                    </div>
                    <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Biaya Operasional</label>

                    <div class="col-sm-3">
                        <input type="text"  value="'.uang(sum_operasional($data->id)).'" readonly class="form-control  input-sm" placeholder="0000">
                    </div>
                    
                    </div>
                </div>
            ';
        }
        return $act;
    }

    public function tampil_risiko_view(request $request)
    {
        $act='';
        foreach(get_risiko($request->id) as $no=>$o){
            $act.='
            <tr style="background:#fff">
                <td>'.($no+1).'</td>
                <td>'.$o->risiko.'</td>
            </tr>';
        }
        return $act;
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

    public function delete_risiko(request $request)
    {
        $id=$request->id;
        
        $data=ProjectRisiko::where('id',$id)->delete();
    }

    public function delete_personal(request $request)
    {
        $id=$request->id;
        
        $data=ProjectPersonal::where('id',$id)->delete();
    }

    public function delete_operasional(request $request)
    {
        $id=$request->id;
        
        $data=ProjectOperasional::where('id',$id)->delete();
    }

    public function delete_material(request $request)
    {
        $id=decoder($request->id);
        
        $data=ProjectMaterial::where('id',$id)->delete();
    }
   
    public function store(request $request){
        error_reporting(0);
        $connomor=ProjectPersonal::where('project_header_id',$request->id)->count();
        $connomoropr=ProjectOperasional::where('project_header_id',$request->id)->count();
        $rules = [];
        $messages = [];
        
        $rules['cost']= 'required';
        $messages['cost.required']= 'Pilih header cost ';
            
        $rules['margin']= 'required|min:0|not_in:0';
        $messages['margin.required']= 'Masukan margin';
        $messages['margin.not_in']= 'Masukan margin';
        
        
        $rules['start_date_retensi']= 'required';
        $messages['start_date_retensi.required']= 'Masukan start date retensi';

        $rules['nik_pm']= 'required';
        $messages['nik_pm.required']= 'Tentukan Project Manager';

        $rules['biaya_pm']= 'required|min:0|not_in:0';
        $messages['biaya_pm.required']= 'Masukan salery PM';
        $messages['biaya_pm.not_in']= 'Masukan salery PM';

        $rules['end_date_retensi']= 'required';
        $messages['end_date_retensi.required']= 'Masukan end date retensi';
        if($connomoropr==0 || $connomor==0){
            $rules['count']= 'required';
            $messages['count.required']= 'Lengkapi biaya personal dan operasional';
        }
       
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
            
                $penomoran=penomoran_cost_center($request->cost);
                $mst=HeaderProject::where('id',$request->id)->first();
                $cek=HeaderProject::where('cost_center',$penomoran)->count();
                if($cek>0){
                    echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Cost Center '.test_penomoran_cost_center($request->cost).' sudah terdaftar</div>';
                }else{
                    
                        $data=HeaderProject::where('id',$request->id)->update([
                            'cost'=>$request->cost,
                            'cost_center'=>$penomoran,
                            'status_id'=>10,
                            'margin'=>ubah_uang($request->margin),
                            'biaya_pm'=>ubah_uang($request->biaya_pm),
                            'start_date_retensi'=>$request->start_date_retensi,
                            'end_date_retensi'=>$request->end_date_retensi,
                            'nik_pm'=>$request->nik_pm,
                            'nama_pm'=>$request->nama_pm,
                            'create_rab'=>date('Y-m-d H:i:s'),
                        ]);

                        $pm=ProjectPersonal::UpdateOrcreate([
                            'project_header_id'=>$request->id,
                            'nik'=>$request->nik_pm,
                        ],[
                            'nama'=>$request->nama_pm,
                            'job_id'=>1,
                            'biaya'=>ubah_uang($request->biaya_pm),
                        ]);
                        $log=LogPengajuan::create([
                            'cost_center'=>$penomoran,
                            'project_header_id'=>$request->id,
                            'deskripsi'=>'RAB dan Cost Center behasil dibuat dan diproses',
                            'status_id'=>10,
                            'nik'=>Auth::user()->username,
                            'role_id'=>Auth::user()->role_id,
                            'revisi'=>1,
                            'created_at'=>date('Y-m-d H:i:s'),
                        ]);
                        echo'@ok';
                    
                }
            
        }
    }

    public function approve_kadis_komersil(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Pilih  status approve ';
       
        if($request->status_id==1){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Masukan alasan pengembalian';
        }else{

        }

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
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_id'=>$request->status_id,
                    'approve_kadis_komersil'=>date('Y-m-d H:i:s'),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                if($request->status_id==1){
                    $catatan=$request->catatan;
                    $revisi=2;
                }else{
                    $catatan='Pengajuan telah disetujui ke kadis komersil';
                    $revisi=1;
                }
                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$catatan,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>$revisi,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
        }
               
        
        
    }

    public function kirim_kadis_komersil (request $request){
        error_reporting(0);
        $id=decoder($request->id);
        $data=HeaderProject::UpdateOrcreate([
            'id'=>$id,
        ],[
            'status_id'=>2,
            'update'=>date('Y-m-d H:i:s'),
        ]);
        $log=LogPengajuan::create([
            'project_header_id'=>$id,
            'deskripsi'=>'Pengajuan telah dikirim kekadis operasional',
            'status_id'=>2,
            'nik'=>Auth::user()->username,
            'role_id'=>Auth::user()->role_id,
            'revisi'=>$revisi,
            'created_at'=>date('Y-m-d H:i:s'),
        ]);
        echo'@ok';
    }

    public function approve_kadis_operasional(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Pilih  status approve ';
       
        if($request->status_id==1){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Masukan alasan pengembalian';
        }else{

        }

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
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_id'=>$request->status_id,
                    'approve_kadis_operasional'=>date('Y-m-d H:i:s'),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                if($request->status_id==1){
                    $catatan=$request->catatan;
                    $revisi=2;
                }else{
                    $catatan='Pengajuan telah disetujui ke kadis operasional';
                    $revisi=1;
                }
                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$catatan,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>$revisi,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
        }
               
        
        
    }

    public function approve_mgr_operasional(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Pilih  status approve ';
       
        if($request->status_id==1){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Masukan alasan pengembalian';
        }else{

        }

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
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_id'=>$request->status_id,
                    'approve_mgr_operasional'=>date('Y-m-d H:i:s'),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                if($request->status_id==1){
                    $catatan=$request->catatan;
                    $revisi=2;
                }else{
                    $catatan='Pengajuan telah disetujui ke manager operasional';
                    $revisi=1;
                }
                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$catatan,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>$revisi,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
        }
               
        
        
    }

    public function approve_direktur_operasional(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Pilih  status approve ';
       
        if($request->status_id==1){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Masukan alasan pengembalian';
        }else{

        }

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
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_id'=>$request->status_id,
                    'approve_direktur_operasional'=>date('Y-m-d H:i:s'),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                if($request->status_id==1){
                    $catatan=$request->catatan;
                    $revisi=2;
                }else{
                    $catatan='Pengajuan telah disetujui ke direktur operasional';
                    $revisi=1;
                }
                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$catatan,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>$revisi,
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
    
    public function store_personal(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        $count=(int) count($request->nik);
        if($count>0){
            $cek=0;
            for($x=0;$x<$count;$x++){
                if($request->nik[$x]==""  || $request->nama[$x]=="" || $request->job_id[$x]==""){
                    $cek+=0;
                }else{
                    $cek+=1;
                }
            }

            if($cek==$count){
                $id=$request->id;
                for($x=0;$x<$count;$x++){
                    if($request->nik[$x]==""  || $request->nama[$x]=="" || $request->job_id[$x]==""){
                        
                    }else{
                        $data=ProjectPersonal::UpdateOrcreate([
                            'project_header_id'=>$id,
                            'nik'=>$request->nik[$x],
                        ],[
                            'nama'=>$request->nama[$x],
                            'job_id'=>$request->job_id[$x],
                            'biaya'=>ubah_uang($request->nilai[$x]),
                        ]);
                    }
                }
                  echo'@ok';  
            }else{
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Lengkapi semua kolom</div></div>';
            }
        }else{
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Lengkapi semua kolom</div></div>';
        }
        
        // $rules['nilai_bidding']= 'required|min:0|not_in:0';
        // $messages['nilai_bidding.required']= 'Masukan nilai bidding';
        // $messages['nilai_bidding.not_in']= 'Masukan nilai bidding';
        
        // $rules['terbilang']= 'required';
        // $messages['terbilang.required']= 'Masukan terbilang';
       
        
        // $rules['bidding_date']= 'required';
        // $messages['bidding_date.required']= 'Masukan tanggal bidding';

        // $rules['status_id']= 'required';
        // $messages['status_id.required']= 'Masukan status';

        // $rules['hasil_bidding']= 'required';
        // $messages['hasil_bidding.required']= 'Masukan hasil bidding';
        

        // $validator = Validator::make($request->all(), $rules, $messages);
        // $val=$validator->Errors();


        // if ($validator->fails()) {
        //     echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
        //         foreach(parsing_validator($val) as $value){
                    
        //             foreach($value as $isi){
        //                 echo'-&nbsp;'.$isi.'<br>';
        //             }
        //         }
        //     echo'</div></div>';
        // }else{
        //         $data=HeaderProject::UpdateOrcreate([
        //             'id'=>$request->id,
        //         ],[
        //             'status_id'=>$request->status_id,
        //             'bidding_date'=>$request->bidding_date,
        //             'hasil_bidding'=>$request->hasil_bidding,
        //             'nilai_bidding'=>ubah_uang($request->nilai_bidding),
        //             'update'=>date('Y-m-d H:i:s'),
        //         ]);

        //         if($request->status_id==50){
        //             $revisi=2;
        //         }else{
        //             $revisi=1;
        //         }
        //         $log=LogPengajuan::create([
        //             'project_header_id'=>$request->id,
        //             'deskripsi'=>$request->hasil_bidding,
        //             'status_id'=>$request->status_id,
        //             'nik'=>Auth::user()->username,
        //             'role_id'=>Auth::user()->role_id,
        //             'revisi'=>$revisi,
        //             'created_at'=>date('Y-m-d H:i:s'),
        //         ]);
        //         echo'@ok';
        // }
               
        
        
    }
    
    public function store_operasional(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        $count=(int) count($request->keterangan);
        if($count>0){
            $cek=0;
            for($x=0;$x<$count;$x++){
                if($request->keterangan[$x]==""  || $request->biaya[$x]==""){
                    $cek+=0;
                }else{
                    $cek+=1;
                }
            }

            if($cek==$count){
                $id=$request->id;
                for($x=0;$x<$count;$x++){
                    if($request->keterangan[$x]==""  || $request->biaya[$x]==""){
                        
                    }else{
                        $data=ProjectOperasional::UpdateOrcreate([
                            'project_header_id'=>$id,
                            'keterangan'=>$request->keterangan[$x],
                        ],[
                            'biaya'=>ubah_uang($request->biaya[$x]),
                        ]);
                    }
                }
                  echo'@ok';  
            }else{
                echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Lengkapi semua kolom</div></div>';
            }
        }else{
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof"> Lengkapi semua kolom</div></div>';
        }
        
        // $rules['nilai_bidding']= 'required|min:0|not_in:0';
        // $messages['nilai_bidding.required']= 'Masukan nilai bidding';
        // $messages['nilai_bidding.not_in']= 'Masukan nilai bidding';
        
        // $rules['terbilang']= 'required';
        // $messages['terbilang.required']= 'Masukan terbilang';
       
        
        // $rules['bidding_date']= 'required';
        // $messages['bidding_date.required']= 'Masukan tanggal bidding';

        // $rules['status_id']= 'required';
        // $messages['status_id.required']= 'Masukan status';

        // $rules['hasil_bidding']= 'required';
        // $messages['hasil_bidding.required']= 'Masukan hasil bidding';
        

        // $validator = Validator::make($request->all(), $rules, $messages);
        // $val=$validator->Errors();


        // if ($validator->fails()) {
        //     echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
        //         foreach(parsing_validator($val) as $value){
                    
        //             foreach($value as $isi){
        //                 echo'-&nbsp;'.$isi.'<br>';
        //             }
        //         }
        //     echo'</div></div>';
        // }else{
        //         $data=HeaderProject::UpdateOrcreate([
        //             'id'=>$request->id,
        //         ],[
        //             'status_id'=>$request->status_id,
        //             'bidding_date'=>$request->bidding_date,
        //             'hasil_bidding'=>$request->hasil_bidding,
        //             'nilai_bidding'=>ubah_uang($request->nilai_bidding),
        //             'update'=>date('Y-m-d H:i:s'),
        //         ]);

        //         if($request->status_id==50){
        //             $revisi=2;
        //         }else{
        //             $revisi=1;
        //         }
        //         $log=LogPengajuan::create([
        //             'project_header_id'=>$request->id,
        //             'deskripsi'=>$request->hasil_bidding,
        //             'status_id'=>$request->status_id,
        //             'nik'=>Auth::user()->username,
        //             'role_id'=>Auth::user()->role_id,
        //             'revisi'=>$revisi,
        //             'created_at'=>date('Y-m-d H:i:s'),
        //         ]);
        //         echo'@ok';
        // }
               
        
        
    }

    public function store_negosiasi(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['nilai']= 'required|min:0|not_in:0';
        $messages['nilai.required']= 'Masukan nilai kontrak';
        $messages['nilai.not_in']= 'Masukan nilai kontrak';
        

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
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_id'=>8,
                    'nilai'=>ubah_uang($request->nilai),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                
                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>'Proses negosiasi dan lanjut keproses kontrak',
                    'status_id'=>8,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>1,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
        }
               
        
        
    }
    public function store_periode_personal(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $count= count((array) $request->project_personal_id);
        if($count>0){
            
        }else{
            $rules['not']= 'required|min:0|not_in:0';
            $messages['not.required']= 'Pilih personal';
        }
        

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
                $periode=ProjectPeriode::where('id',$request->project_header_id)->first();
                $delete=ProjectAnggaranperiode::where('project_header_id',$request->project_header_id)->where('kategori',1)->where('project_periode_id',$request->project_periode_id)->delete();
                for($x=0;$x<$count;$x++){
                    $mst=ProjectPersonal::where('id',$request->project_personal_id[$x])->first();
                    $data=ProjectAnggaranperiode::UpdateOrcreate([
                        'project_header_id'=>$request->project_header_id,
                        'project_periode_id'=>$request->project_periode_id,
                        'biaya_id'=>$request->project_personal_id[$x],
                        'kategori'=>1,
                    ],[
                        'biaya'=>$mst->biaya,
                        'keterangan'=>$mst->nama,
                        'bulan'=>$periode->bulan,
                        'tahun'=>$periode->tahun,
                    ]);
                }
                
                echo '@ok';
        }
               
        
        
    }
    public function store_periode_operasional(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $count= count((array) $request->project_operasional_id);
        if($count>0){
            
        }else{
            $rules['not']= 'required|min:0|not_in:0';
            $messages['not.required']= 'Pilih personal';
        }
        

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
                $periode=ProjectPeriode::where('id',$request->project_header_id)->first();
                $delete=ProjectAnggaranperiode::where('project_header_id',$request->project_header_id)->where('kategori',2)->where('project_periode_id',$request->project_periode_id)->delete();
                for($x=0;$x<$count;$x++){
                    $mst=ProjectOperasional::where('id',$request->project_operasional_id[$x])->first();
                    $data=ProjectAnggaranperiode::UpdateOrcreate([
                        'project_header_id'=>$request->project_header_id,
                        'project_periode_id'=>$request->project_periode_id,
                        'biaya_id'=>$request->project_operasional_id[$x],
                        'kategori'=>2,
                    ],[
                        'biaya'=>$mst->biaya,
                        'keterangan'=>$mst->keterangan,
                        'bulan'=>$periode->bulan,
                        'tahun'=>$periode->tahun,
                    ]);
                }
                
                echo '@ok';
        }
               
        
        
    }
}
