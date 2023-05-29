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
use App\Models\Pengadaan;
use App\Models\Viewrole;
use App\Models\Viewstatus;
use App\Models\ViewGetPengadaan;
use App\Models\HeaderProject;
use App\Models\ViewHeaderProject;
use App\Models\ProjectFileprogres;
use App\Models\ProjectMaterial;
use App\Models\ProjectPersonal;
use App\Models\ViewHeaderProjectcontrol;
use App\Models\ProjectOperasional;
use App\Models\StatusTask;
use App\Models\StatusProgres;
use App\Models\ViewProjectMaterial;
use App\Models\ViewProjecttask;
use App\Models\ProjectTask;
use App\Models\ProjectRisiko;
use App\Models\ProjectPeriode;
use App\Models\ProjectAnggaranperiode;
use App\Models\Material;
use App\Models\LogPengajuan;
use App\Models\ProjectProgres;
use App\Models\ViewPengadaan;
use App\Models\ViewCost;
use App\Models\User;

class PengadaanController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        if(Auth::user()->role_id==5){
            return view('pengadaan.index',compact('template'));
        }else{
            return view('error');
        }
        
    }
   
    public function view(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        $data = ViewPengadaan::where('id',$id)->first();
        return view('pengadaan.view',compact('template','data','id','mst'));
        
        
    }
    public function modal_verifikasi(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        $data = ViewProjectmaterial::where('id',$id)->first();
        return view('pengadaan.modal_pengadaan',compact('template','data','id','mst'));
        
        
    }
    
    public function get_data(request $request)
    {
        error_reporting(0);
        $query = ViewPengadaan::query();
        
        $data = $query->whereIn('status_id',array(10,11))->orderBy('id','Desc')->get();

        return Datatables::of($data)
        ->addColumn('pengadaan', function ($row) {
            $btn='<b>'.$row->total_selesai_pengadaan.'/'.$row->total_pengadaan.'</b>';
            return $btn;
        })
        
        ->addColumn('action', function ($row) {
            if($row->total_note>0){
                $color='success';
            }else{
                $color='default';
            }
            $btn='
                <div class="btn-group">
                    <button type="button" class="btn btn-'.$color.' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Act <i class="fa fa-sort-desc"></i> 
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:;"  onclick="location.assign(`'.url('pengadaan/view').'?id='.encoder($row->id).'`)">Detail</a></li>
                    </ul>
                </div>
            ';
           
            return $btn;
        })
        
        ->rawColumns(['action','pengadaan'])
        ->make(true);
    }
    public function get_data_material(request $request)
    {
        error_reporting(0);
        $query = ViewProjectmaterial::query();
        if($request->status_material_id>0){
            $data = $query->where('status_pengadaan',$request->status_material_id);
        }
        if($request->status_aset_id>0){
            $data = $query->where('status_aset_id',$request->status_aset_id);
        }
        $data = $query->where('project_header_id',$request->id)->where('kategori_ide',1)->where('state',2)->orderBy('status_pengadaan','Asc')->get();

        return Datatables::of($data)
        ->addColumn('pilih', function ($row) {
            if($row->status_pengadaan==1){
                return '<input type="checkbox" name="project_material_id[]" value="'.$row->id.'">';
            }else{
                return '<i class="fa fa-check-square-o"></i>';
            }
            
             
        })
        ->addColumn('action', function ($row) {
            
            $btn='<span class="btn btn-info btn-xs"  onclick="show_detail('.$row->id.')"><i class="fa fa-cog"></i></span>';
           
            return $btn;
        })
        
        ->rawColumns(['action','pengadaan','pilih'])
        ->make(true);
    }
    public function get_data_pengadaan(request $request)
    {
        error_reporting(0);
        $query = ViewGetPengadaan::query();
        // if($request->status_material_id>0){
        //     $data = $query->where('status_material_id',$request->status_material_id);
        // }
        
        $data = $query->where('cost_center',$request->cost_center)->orderBy('keterangan','Asc')->get();

        return Datatables::of($data)
        ->addColumn('pilih', function ($row) {
            if($row->status_publish==0){
                return '<input type="checkbox" name="ide[]" value="'.$row->ide.'">';
            }else{
                return '<input type="checkbox" disabled >';
            }
            
             
        })
        ->addColumn('action', function ($row) {
            if($row->status_publish==0){
                return '<span class="btn btn-danger btn-xs" onclick="delete_pengadaan('.$row->id.','.$row->ide.','.$row->tipe.')">Cancel</span>';
            }else{
                return '<span class="btn btn-default btn-xs">Cancel</span>';
            }
            
        })
        
        ->rawColumns(['action','pengadaan','pilih'])
        ->make(true);
    }
    public function get_data_task(request $request)
    {
        error_reporting(0);
        $query = ViewProjecttask::query();
        // if($request->hide==1){
        //     $data = $query->where('active',0);
        // }else{
        //     $data = $query->where('active',1);
        // }
        
        $data = $query->where('project_header_id',$request->id)->orderBy('id','Desc')->get();

        return Datatables::of($data)
        ->addColumn('action', function ($row) {
            
                $btn='
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        View<i class="fa fa-sort-desc"></i> 
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;"  onclick="delete_data(`'.encoder($row->id).'`,1)">Un Hidden</a></li>
                        </ul>
                    </div>
                ';
            
            return $btn;
        })
        ->addColumn('status_task_nya', function ($row) {
            $btn='<span class="btn btn-'.$row->color.' btn-sm" onclick="tambah('.$row->id.')">'.$row->status_task.'</span>';
            return $btn;
        })
        ->addColumn('duedate', function ($row) {
            $btn='<font color="#7c7c95" style=""><b>'.$row->start_date_at.' s/d '.$row->end_date_at.'</b></font>';
            return $btn;
        })
        ->addColumn('progresnya', function ($row) {
            $btn='<font color="#7c7c95" style=""><b>'.$row->progres.'%</b></font>';
            return $btn;
        })
        ->addColumn('add', function ($row) {
            $btn='<span class="btn btn-success btn-xs" onclick="show_progres('.$row->id.')" title="Progres Task"><i class="fa fa-pencil"></i></span>';
            return $btn;
        })
        ->addColumn('status_now', function ($row) {
            if($row->selisih_duedate>0){
                $btn='<font color="#000" style="font-style:italic"><b>'.$row->selisih_duedate.' Hari</b></font>';
            
            }else{
                $btn='<font color="red" style="font-style:italic"><b>'.$row->selisih_duedate.' Hari</b></font>';
            }
            return $btn;
        })
            ->rawColumns(['action','status_now','status_task_nya','add','duedate','progresnya'])
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

    public function tampil_risiko(request $request)
    {
        $act='';
        foreach(get_risiko($request->id) as $no=>$o){
            $act.='
            <tr style="background:#fff">
                <td>'.($no+1).'</td>
                <td>'.$o->risiko.'</td>
                <td>'.$o->status_risiko.'</td>
                <td><span class="btn btn-danger btn-xs" onclick="delete_risiko('.$o->id.')"><i class="fa fa-close"></i></span></td>
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
        $id=$request->id;
        $ide=$request->ide;
        $tipe=$request->tipe;
        if($tipe==1){
            $data=ProjectMaterial::where('id',$ide)->update(['status_pengadaan'=>1]);
        }else{

        }
        $datapeng=Pengadaan::where('id',$id)->delete();
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
        $id=$request->id;
        
        $data=ProjectMaterial::where('id',$id)->delete();
    }
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['customer_code']= 'required';
        $messages['customer_code.required']= 'Pilih  customer ';

        $rules['nik_pm']= 'required';
        $messages['nik_pm.required']= 'Pilih  project manager ';

        $rules['kategori_project_id']= 'required';
        $messages['kategori_project_id.required']= 'Pilih  Kategori Project ';
       
        $rules['tipe_project_id']= 'required';
        $messages['tipe_project_id.required']= 'Pilih  Tipe Project ';

        $rules['deskripsi_project']= 'required';
        $messages['deskripsi_project.required']= 'Masukan Ruang Lingkup Project';
        
        $rules['start_date']= 'required';
        $messages['start_date.required']= 'Masukan start date ';

        $rules['end_date']= 'required';
        $messages['end_date.required']= 'Masukan end date ';

        $rules['nilai_project']= 'required|min:0|not_in:0';
        $messages['nilai_project.required']= 'Masukan nilai project ';
        $messages['nilai_project.not_in']= 'Masukan nilai project ';
        
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
            if(count_material_pengadaan($request->id)>0){
                $pengadaan=1;
                $progrespengadaan=1;
            }else{
                $pengadaan=2;
                $progrespengadaan=1;
            }

                
               
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'customer_code'=>$request->customer_code,
                    'nik_pm'=>$request->nik_pm,
                    'status_pengadaan_id'=>$pengadaan,
                    'progres_pengadaan'=>$progrespengadaan,
                    'deskripsi_project'=>$request->deskripsi_project,
                    'start_date'=>$request->start_date,
                    'kategori_project_id'=>$request->kategori_project_id,
                    'tipe_project_id'=>$request->tipe_project_id, 
                    'end_date'=>$request->end_date,
                    'nilai_project'=>ubah_uang($request->nilai_project),
                    'username'=>Auth::user()->username,
                    'active'=>1,
                    'create'=>date('Y-m-d H:i:s'),
                ]);

                
                echo'@ok@'.encoder($request->id);
            
           
        }
    }
    public function publish(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['customer_code']= 'required';
        $messages['customer_code.required']= 'Pilih  customer ';
        $rules['nik_pm']= 'required';
        $messages['nik_pm.required']= 'Pilih  project manager ';

        $rules['kategori_project_id']= 'required';
        $messages['kategori_project_id.required']= 'Pilih  Kategori Project ';

        $rules['tipe_project_id']= 'required';
        $messages['tipe_project_id.required']= 'Pilih  Tipe Project ';
       
        $rules['deskripsi_project']= 'required';
        $messages['deskripsi_project.required']= 'Masukan Ruang Lingkup Project';
        
        $rules['start_date']= 'required';
        $messages['start_date.required']= 'Masukan start date ';

        $rules['end_date']= 'required';
        $messages['end_date.required']= 'Masukan end date ';
        
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
                    'customer_code'=>$request->customer_code,
                    'deskripsi_project'=>$request->deskripsi_project,
                    'start_date'=>$request->start_date,
                    'nik_pm'=>$request->nik_pm,
                    'kategori_project_id'=>$request->kategori_project_id,
                    'tipe_project_id'=>$request->tipe_project_id,
                    'end_date'=>$request->end_date,
                    'active'=>1,
                    'status_kontrak_id'=>2,
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>'Kontrak telah dipublish',
                    'status_id'=>2,
                    'kat'=>2,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
             
           
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
       
        if($request->status_id==8){
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
                    'approve_kadis_operasional_kontrak'=>date('Y-m-d H:i:s'),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                if($request->status_id==8){
                    $catatan=$request->catatan;
                    $revisi=2;
                }else{
                    $catatan='RAB telah disetujui ke kadis operasional';
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
    public function tampil_material(request $request)
    {
        $act='';
        $sum=0;
        $sumact=0;
        $data=HeaderProject::where('id',$request->id)->first();
        $status=$data->status_id;
        
            foreach(get_material($request->id,1) as $no=>$o){
                $sum+=$o->total;
                $sumact+=$o->total_actual;
                if($o->status_material_id==1){
                    $clr='yellow';
                }else{
                    if($o->status_material_id==2){
                        $clr='aqua';
                    }else{
                        $clr='#fff';
                    }
                }
                
                    
                    $act.='
                    <tr style="background:#fff" >
                        <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                        <td style="padding: 2px 2px 2px 8px;">'.$o->kode_material.'</td>
                        <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                        <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                        <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya_actual).'</td>
                        <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>
                        <td style="padding: 2px 2px 2px 8px;background:'.$clr.'" class="text-center" >'.$o->st_material.'</td>
                        <td style="padding: 2px 2px 2px 8px;" class="text-center" >'.$o->singkatan_aset.'</td>
                        <td style="padding: 2px 2px 2px 8px;" class="text-center" >'.$o->nama_status_pengadaan.'</td>';
                        if($o->status_pengadaan==1){
                            $act.='
                            <td style="padding: 2px 2px 2px 8px;">
                                <span class="btn btn-success btn-xs" onclick="tambah_material('.$o->id.')"><i class="fa fa-search"></i></span>
                                <span class="btn btn-danger btn-xs" onclick="delete_material('.$o->id.')"><i class="fa fa-close"></i></span>
                            </td>';
                        }else{
                            $act.='
                            <td style="padding: 2px 2px 2px 8px;">
                                <span class="btn btn-default btn-xs" ><i class="fa fa-search"></i></span>
                                <span class="btn btn-default btn-xs" ><i class="fa fa-close"></i></span>
                            </td>';
                        }
                        $act.='
                            
                    </tr>';
            }   
            $act.='
            <tr style="background:#fff">
                <td colspan="4" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;">Total (Rp)</td>
                <td colspan="2" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sum).'</td>
                <td colspan="2" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sumact).'</td>
                <td colspan="5" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right"></td>
            </tr>';
        
        
        return $act;
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
    
    
    public function store_material(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        $rules['biaya_actual']= 'required|min:0|not_in:0';
        $messages['biaya_actual.required']= 'Masukan harga satuan';
        $messages['biaya_actual.not_in']= 'Masukan harga satuan';

        $rules['qty']= 'required|min:0|not_in:0';
        $messages['qty.required']= 'Masukan qty';
        $messages['qty.not_in']= 'Masukan qty';
        
        $rules['status_aset_id']= 'required';
        $messages['status_aset_id.required']= 'Pilih status aset';
        
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
                $mst=ProjectMaterial::where('id',$request->id)->first();
                if($mst->status_pengadaan==1){
                    $data=ProjectMaterial::UpdateOrcreate([
                        'id'=>$request->id,
                    ],[
                        'biaya_actual'=>ubah_uang($request->biaya_actual),
                        'qty'=>ubah_uang($request->qty),
                        'total'=>(ubah_uang($request->qty)*$mst->biaya),
                        'total_actual'=>(ubah_uang($request->qty)*ubah_uang($request->biaya_actual)),
                        'status_pengadaan'=>$request->status_material_id,
                        'status_material_id'=>$request->status_material_id,
                        'status_aset_id'=>$request->status_aset_id,
                        
                    ]);
                        
                    echo'@ok';  
                }else{
                    echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">Material dalam proses pengadaan</div></div>';
                }
        
        }
       
        
    }
    public function dashboard_task(request $request){
        $data=ViewHeaderProjectcontrol::where('id',$request->id)->first();
        $echo='';
        if($data->selisih_duedate>0){
            $color="blue";
            $text="#fff";
        }else{
            $color="red";
            $text="#fff";
        }
        $echo.='<div class="row" style="display: contents;">
                    <div class="col-md-2 text-center" style="padding:1%;background:#ecd4fb;border:solid 1px #fff">TOTAL TASK<h3>'.$data->total_task.'</h3></div>
                    <div class="col-md-2 text-center" style="padding:1%;background:#ecd4fb;border:solid 1px #fff">IN-PROGRES<h3>'.($data->total_task-$data->total_task_selesai).'</h3></div>
                    <div class="col-md-2 text-center" style="padding:1%;background:#ecd4fb;border:solid 1px #fff">SOLVED<h3>'.$data->total_task_selesai.'</h3></div>
                    <div class="col-md-2 text-center" style="padding:1%;background:#ecd4fb;border:solid 1px #fff">OUT-STANDING<h3>'.$data->total_out.'</h3></div>
                    <div class="col-md-2 text-center" style="padding:1%;background:yellow;border:solid 1px #fff">PROGRES<h3>'.$data->total_task_progres.'%</h3></div>
                    <div class="col-md-2 text-center" style="padding:1%;background:'.$color.';color:'.$text.';border:solid 1px #fff">SISA WAKTU<h3>'.$data->selisih_duedate.' Hari</h3></div>
                </div>';
        return $echo;
    }
    public function store_material_pm(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];

        $rules['kode_material']= 'required';
        $messages['kode_material.required']= 'Pilih material';

        $rules['biaya']= 'required|min:0|not_in:0';
        $messages['biaya.required']= 'Masukan harga satuan';
        $messages['biaya.not_in']= 'Masukan harga satuan';

        $rules['qty']= 'required|min:0|not_in:0';
        $messages['qty.required']= 'Masukan qty';
        $messages['qty.not_in']= 'Masukan qty';
        
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
                $mst=ProjectMaterial::where('id',$request->id)->first();
                if($request->id==0){
                    echo $request->nama_material;
                    $data=ProjectMaterial::create([
                        'project_header_id'=>$request->project_header_id,
                        'kode_material'=>$request->kode_material,
                        'nama_material'=>$request->nama_material,
                        'status'=>1,
                      
                        'biaya'=>ubah_uang($request->biaya),
                        'biaya_actual'=>ubah_uang($request->biaya),
                        'qty'=>ubah_uang($request->qty),
                        'status_pengadaan'=>1,
                        'status'=>1,
                        'total'=>ubah_uang($request->total),
                        'total_actual'=>ubah_uang($request->total),
                        'nama_material'=>$request->nama_material,
                        'created_at'=>date('Y-m-d H:i:s'),
                    ]);
                    echo'@ok';  
                }else{
                    if($mst->status_pengadaan==1){
                        $data=ProjectMaterial::UpdateOrcreate([
                            'id'=>$request->id,
                        ],[
                            'biaya'=>ubah_uang($request->biaya),
                            'qty'=>ubah_uang($request->qty),
                            'total'=>(ubah_uang($request->qty)*$mst->biaya_actual),
                            
                        ]);
                            
                        echo'@ok';  
                    }else{
                        echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">Material dalam proses pengadaan</div></div>';
                    }
                }
                
        
        }
       
        
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
    public function store_task(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['task']= 'required';
        $messages['task.required']= 'Masukan task pekerjaan';

        $rules['status_task_id']= 'required';
        $messages['status_task_id.required']= 'Masukan status task';

        $rules['start']= 'required';
        $messages['start.required']= 'Masukan start_data';

        $rules['end']= 'required';
        $messages['end.required']= 'Masukan end_data';


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

                $mst=StatusTask::where('id',$request->status_task_id)->first();
                $data=ProjectTask::create([
                    'project_header_id'=>$request->project_header_id,
                    'status_task_id'=>$request->status_task_id,
                    'progres'=>$mst->progres,
                    'task'=>$request->task,
                    'start'=>$request->start,
                    'end'=>$request->end,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
        }
               
        
        
    }
    public function store_progres(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        $files = $request->file('file');
        
        $count=count((array) $request->file('file'));
        $rules['catatan']= 'required';
        $messages['catatan.required']= 'Masukan catatan pekerjaan '.$count.'/'.$sum;

        if($count>0){
            $ary = array('gif','jpg','png','jpeg');
            $sum=0;
            foreach($files as $x=>$file) {
                $ret=$request->file[$x];
                if(in_array($ret->getClientOriginalExtension(),$ary)){
                    $sum+=1;
                }else{
                    $sum+=0;
                }
            }
            if($count>$sum){
                $rules['attach']= 'required';
                $messages['attach.required']= "Format file ('gif','jpg','png','jpeg')";
            }
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

                $ors=ProjectTask::where('id',$request->id)->first();
                $mst=StatusTask::where('id',$request->status_task_id)->first();
                $prog=StatusProgres::where('progres',$request->progres)->first();
                if($request->status_task_id==3){
                    $progres=100;
                    $status_task_id=$request->status_task_id;
                }else{
                    if($request->status_task_id==1){
                        $progres=0;
                        $status_task_id=$prog->status_task_id;
                    }else{
                        $progres=$request->progres;
                        $status_task_id=$prog->status_task_id;
                    }
                    
                    
                }
                
                $data=ProjectTask::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_task_id'=>$status_task_id,
                    'progres'=>$progres,
                    'updated_at'=>date('Y-m-d H:i:s'),
                ]);

                $progres=ProjectProgres::create([
                    'project_header_id'=>$ors->project_header_id,
                    'project_task_id'=>$request->id,
                    'catatan'=>$request->catatan,
                    'progres'=>$progres,
                    'status_task_id'=>$status_task_id,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'users_id'=>Auth::user()->id,
                ]);

                if($count>0){
                    
                    $filew = \Storage::disk('public_progres');
                    foreach($files as $x=>$file) {
                        $lampiran = $request->file[$x];
                        $tir=$lampiran->getMimeType();
                        $tiepe=explode('/',$tir);
                        $lampiranFileName ='PRJECTNO_'.$request->id.'-'.$x.date('ymdhis').'.'. $lampiran->getClientOriginalExtension();
                        $filePath2 =$lampiranFileName;
                            if($filew->put($filePath2, file_get_contents($lampiran))){
                                $failes=ProjectFileprogres::create([
                                    'project_task_id'=>$request->id,
                                    'file'=>$filePath2,
                                ]);
                            }
                            // echo $filePath2;
                        
                    }
                }
                echo'@ok';
        }
               
        
        
    }
    public function store_pengadaan(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        $count=count((array) $request->project_material_id);
        if($count==0){
            $rules['nilai']= 'required';
            $messages['nilai.required']= 'Masukan material';
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
            
            $data=ViewProjectMaterial::whereIn('id',$request->project_material_id)->get();
            foreach($data as $no=>$o){
                $data=Pengadaan::UpdateOrcreate([
                    'ide'=>$o->id,
                    'tipe'=>1,
                    'cost_center'=>$o->cost_center_project,
                ],[
                    'project'=>$o->deskripsi_project,
                    'keterangan'=>$o->nama_material,
                    'status_aset'=>$o->nama_aset,
                    'status_publish'=>0,
                    'qty'=>$o->qty,
                    'harga'=>$o->biaya_actual,
                    'total'=>$o->total_actual,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
            }
            $update=ProjectMaterial::whereIn('id',$request->project_material_id)->where('state',2)->update(['status_pengadaan'=>2]);
                

                echo '@ok';
        }
               
        
        
    }
    public function store_ready(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        $count=count((array) $request->project_material_id);
        if($count==0){
            $rules['nilai']= 'required';
            $messages['nilai.required']= 'Masukan material';
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
            
            
            $update=ProjectMaterial::whereIn('id',$request->project_material_id)->where('state',2)->update(['status_pengadaan'=>3]);
                

                echo '@ok';
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
