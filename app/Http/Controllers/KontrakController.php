<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Imports\ImportMaterialKontrak;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\ViewEmploye;
use App\Models\ViewLog;
use App\Models\Viewrole;
use App\Models\Viewstatus;
use App\Models\Role;
use App\Models\HeaderProject;
use App\Models\ViewHeaderProject;
use App\Models\ProjectFileprogres;
use App\Models\ProjectMaterial;
use App\Models\ProjectPersonal;
use App\Models\ProjectOperasional;
use App\Models\ViewHeaderProjectcontrol;
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
use App\Models\ViewCost;
use App\Models\User;
use PDF;
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
        }elseif(Auth::user()->role_id==8){
            return view('kontrak.index_komersil',compact('template'));
        }elseif(Auth::user()->role_id==3){
            return view('kontrak.index_mgr_operasional',compact('template'));
        }else{
            return view('error');
        }
        
    }
    public function form_kontrak(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewHeaderProject::where('id',$id)->first();
        if($request->tab==""){
            $tab=1;
        }else{
            $tab=$request->tab;
        }
        
        if($id==0){
            $disabled='';
            $nom=1;
            $nomper=1;
            $nommat=1;
        }else{
            $disabled='readonly';
            $connomor=ProjectRisiko::where('project_header_id',$id)->count();
            $connomoropr=ProjectOperasional::where('project_header_id',$id)->count();
            $connomormat=ProjectMaterial::where('project_header_id',$id)->count();
            $nom=($connomor+1);
            $nomper=($connomoropr+1);
            $nommat=($connomormat+1);
        }
        if(Auth::user()->role_id==6){
            return view('kontrak.form_kontrak',compact('template','data','disabled','id','nom','nomper','nommat','tab'));
            
        }
        
       
    }
    public function form_material(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        
        $data=ViewProjectMaterial::where('id',$id)->first();
        return view('kontrak.form_material',compact('template','data','id'));
    }
    public function index_control(request $request)
    {
        error_reporting(0);
        $template='top';
        if($request->text==""){
            $text=0;
        }else{
            $text=$request->text;
        }
        if(count_pm()>0){
            return view('kontrak.index_control',compact('template','text'));
        }else{
            return view('error');
        }
        
    }
    public function task(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        $count = ViewHeaderProject::where('id',$id)->where('nik_pm',Auth::user()->username)->count();
        $data = ViewHeaderProject::where('id',$id)->first();
        $connomor=ProjectRisiko::where('project_header_id',$id)->count();
        $connomoropr=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',2)->where('state',2)->count();
        $connomorjasa=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',3)->where('state',2)->count();
        $connomormat=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',1)->where('state',2)->count();
        $nom=($connomor+1);
        $nomper=($connomoropr+1);
        $nommat=($connomormat+1);
        $nomjasa=($connomorjasa+1);
        if($count>0){
            return view('kontrak.task',compact('template','data','id','nom','nomper','nommat','tab','nomjasa'));
        }else{
            return view('error');
        }
        
    }
    public function modal_task(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        $mst = ViewHeaderProject::where('id',$request->project_header_id)->first();
        $data = ViewProjecttask::where('id',$id)->first();
        return view('kontrak.modal_task',compact('template','data','id','mst'));
        
        
    }
    public function modal_progres(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        $data = ViewProjecttask::where('id',$id)->first();
        return view('kontrak.modal_progres',compact('template','data','id','mst'));
        
        
    }
    public function get_data_control(request $request)
    {
        error_reporting(0);
        $query = ViewHeaderProjectcontrol::query();
        if($request->text==0){
            
        }else{
            $data = $query->where('deskripsi_project','LIKE','%'.$request->text.'%')->orWhere('customer','LIKE','%'.$request->text.'%')->get();
        }
        
        $data = $query->where('nik_pm',Auth::user()->username)->get();

        $success=[];
        
        return response()->json($data, 200);
    }
    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->id);
        
        $data=ViewHeaderProject::where('id',$id)->first();
        if($request->tab==""){
            $tab=1;
        }else{
            $tab=$request->tab;
        }
        
        if($id==0){
            $disabled='';
            $nom=1;
            $nomper=1;
            $nomjasa=1;
            $nommat=1;
        }else{
            $disabled='readonly';
            $connomor=ProjectRisiko::where('project_header_id',$id)->count();
            $connomoropr=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',2)->where('state',2)->count();
            $connomorjasa=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',3)->where('state',2)->count();
            $connomormat=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',1)->where('state',2)->count();
            $nom=($connomor+1);
            $nomper=($connomoropr+1);
            $nommat=($connomormat+1);
            $nomjasa=($connomorjasa+1);
        }
        if(Auth::user()->role_id==6){
            if($data->status_id==9){
                return view('kontrak.view_data',compact('template','data','disabled','id','nom','nomper','nommat','tab','nomjasa'));
            }else{
                if($id==0){
                    return view('kontrak.view_data',compact('template','data','disabled','id','nom','nomper','nommat','tab','nomjasa'));
                }else{
                    return view('kontrak.view',compact('template','data','disabled','id','nom','nomper','nommat','tab','nomjasa'));
                }
                
                
                
            }
        }
        if(Auth::user()->role_id==4){
            if($data->status_id==2){
                return view('kontrak.view_approve_komersil',compact('template','data','disabled','id'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','id'));
                
            }
        }
        if(Auth::user()->role_id==7){
            if($data->status_id==3){
                return view('kontrak.view_approve_operasional',compact('template','data','disabled','id'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','id'));
                
            }
        }
        if(Auth::user()->role_id==3){
            if($data->status_id==4){
                return view('kontrak.view_approve_mgr_operasional',compact('template','data','disabled','id'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','id'));
                
            }
        }
        if(Auth::user()->role_id==2){
            if($data->status_id==5){
                return view('kontrak.view_approve_direktur_operasional',compact('template','data','disabled','id'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','id'));
                
            }
        }
        if(Auth::user()->role_id==5){
            if($data->status_id==6){
                return view('kontrak.view_procurement',compact('template','data','disabled','id'));
            }else{
                return view('kontrak.view',compact('template','data','disabled','id'));
                
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
    public function modal_material(request $request)
    {
        error_reporting(0);
        $template='top';
        $no=$request->no;
        return view('kontrak.modal_material',compact('no'));
    }
    public function tampil_material_kontrak(request $request)
    {
        if($request->id>0){
            $act='';
           $mtr=HeaderProject::where('id',$request->id)->first();
           $sum=0;
           $sumact=0;
           $data=HeaderProject::where('id',$request->id)->first();
           $query=ViewProjectMaterial::query();
           if($request->cari!=null){
                $get=$query->where('nama_material','LIKE',$request->cari.'%');
           }
           
           $get=$query->where('state',2)->where('project_header_id',$data->id)->where('kategori_ide',1)->orderBy('status_pengadaan','Asc')->get();
           $status=$data->status_id;
                
                
               foreach($get as $no=>$o){
                   $sum+=$o->total;
                   
                       $act.='
                       <tr style="background:#fff" >
                           <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                           <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                           <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                           <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                           <td style="padding: 2px 2px 2px 8px;">'.$o->satuan_material.'</td>
                           <td style="padding: 2px 2px 2px 8px;">'.$o->singkatan_pengadaan.'</td>
                           <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>';
                           if($o->status_pengadaan==1){
                               $act.='<td style="padding: 2px 2px 2px 8px;"><span class="btn btn-danger btn-xs" onclick="delete_material('.$o->id.')"><i class="fa fa-close"></i></span></td>';
                           }else{
                               $act.='<td style="padding: 2px 2px 2px 8px;"><span class="btn btn-default btn-xs" ><i class="fa fa-close"></i></span></td>';
                           }
                           $act.='
                       </tr>';
                   
                   
               }
               
               $act.='
               <tr style="background:#fff">
                   <td colspan="6" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;">Total (Rp)</td>
                   <td  style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sum).'</td>
                   <td  style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right"></td>
               </tr>';
                   
           
           
           return $act;
       }
    }
    public function tampil_material(request $request)
    {
        if($request->id>0){
             $act='';
            $mtr=HeaderProject::where('id',$request->id)->first();
            $sum=0;
            $sumact=0;
            $data=HeaderProject::where('id',$request->id)->first();
            $query=ViewProjectMaterial::query();
            if($request->cari!=null){
                    $get=$query->where('nama_material','LIKE',$request->cari.'%');
            }
           
            $get=$query->where('state',2)->where('project_header_id',$data->id)->where('kategori_ide',1)->orderBy('status_pengadaan','Asc')->get();
            $status=$data->status_id;
            
                foreach($get as $no=>$o){
                    $sum+=$o->total;
                    
                        $act.='
                        <tr style="background:#fff" >
                            <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                            <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                            <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                            <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                            <td style="padding: 2px 2px 2px 8px;">'.$o->satuan_material.'</td>
                            <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>';
                            if($status==9){
                                $act.='<td style="padding: 2px 2px 2px 8px;"><span class="btn btn-danger btn-xs" onclick="delete_material('.$o->id.')"><i class="fa fa-close"></i></span></td>';
                            }else{
                                $act.='<td style="padding: 2px 2px 2px 8px;"><span class="btn btn-default btn-xs" ><i class="fa fa-close"></i></span></td>';
                            }
                            $act.='
                        </tr>';
                    
                    
                }
                
                $act.='
                <tr style="background:#fff">
                    <td colspan="5" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;">Total (Rp)</td>
                    <td  style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sum).'</td>
                    <td  style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right"></td>
                </tr>';
                    
            
            
            return $act;
        }
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
            if($request->status_kontrak_id!=""){
                $data = $query->where('status_id',$request->status_kontrak_id);
            }else{
                $data = $query->whereIn('status_id',array(9,10,11));
            }
        }
        if(Auth::user()->role_id==4){
            if($request->status_kontrak_id!=""){
                $data = $query->where('status_id',$request->status_kontrak_id);
            }else{
                $data = $query->whereIn('status_id',array(9,10,11));
            }
            
        }
        if(Auth::user()->role_id==5){
            if($request->status_kontrak_id!=""){
                $data = $query->where('status_id',$request->status_kontrak_id);
            }else{
                $data = $query->where('status_id','>',2);
            }
        }
        if(Auth::user()->role_id==2){
            if($request->status_kontrak_id!=""){
                $data = $query->where('status_id',$request->status_kontrak_id);
            }else{
                $data = $query->where('status_id','>',4);
            }
        }
        if(Auth::user()->role_id==3){
            if($request->status_kontrak_id!=""){
                $data = $query->where('status_id',$request->status_kontrak_id);
            }else{
                $data = $query->where('status_id','>',1);
            }
        }
        if(Auth::user()->role_id==7){
            if($request->status_kontrak_id!=""){
                $data = $query->where('status_id',$request->status_kontrak_id);
            }else{
                $data = $query->where('status_id','>',2);
            }
        }
        if(Auth::user()->role_id==8){
            if($request->status_kontrak_id!=""){
                $data = $query->where('status_id',$request->status_kontrak_id);
            }else{
                $data = $query->where('status_id','>',1);
            }
        }
        $data = $query->orderBy('id','Desc')->get();

        return Datatables::of($data)
        ->addColumn('action', function ($row) {
            if(Auth::user()->role_id==1){

            }
            if(Auth::user()->role_id==2){
                if($row->status_kontrak_id==5){
                    $color='success';
                }else{
                    $color='default';
                }
            }
            if(Auth::user()->role_id==3){
                if($row->status_kontrak_id==4){
                    $color='success';
                }else{
                    $color='default';
                }
            }
            if(Auth::user()->role_id==4){
                if($row->status_kontrak_id==2){
                    $color='success';
                }else{
                    $color='default';
                }
            }
            if(Auth::user()->role_id==5){
                if($row->status_kontrak_id==6){
                    $color='success';
                }else{
                    $color='default';
                }
            }
            if(Auth::user()->role_id==6){
                if(in_array($row->status_kontrak_id, array(0,1,7,8))){
                    $color='success';
                }else{
                    $color='default';
                }
            }
            if(Auth::user()->role_id==7){
                if($row->status_kontrak_id==3){
                    $color='success';
                }else{
                    $color='default';
                }
            }
            if($row->active==1){
                
                    $btn='
                        <div class="btn-group">
                            <button type="button" class="btn btn-'.$color.' btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Act <i class="fa fa-sort-desc"></i> 
                            </button>
                            <ul class="dropdown-menu">';
                                if($row->status_id==9){
                                    $btn.='
                                    <li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($row->id).'`)">View</a></li>
                                    <li><a href="javascript:;"  onclick="delete_data(`'.encoder($row->id).'`,`0`)">Hidden</a></li>
                                    ';
                                }else{
                                    $btn.=tombol_kontrak_act($row->id,$row->status_kontrak_id);
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
            if(deskripsi_alasan($row->id,$row->status_id)!=0){
                $col='danger';
            }else{
                $col='success';
            }
            $btn='<span class="btn btn-'.$col.' btn-xs" onclick="show_timeline(`'.encoder($row->id).'`)" title="Log Aktifitas"><i class="fa fa-history"></i></span>';
            return $btn;
        })
        ->addColumn('status_now', function ($row) {
            if($row->tab>4){
                $btn='<font color="#000" style="font-style:italic"><b>'.$row->status_kontak.'</b></font>';
            
            }else{
                $btn='<font color="#000" style="font-style:italic"><b>Penyusunan</b></font>';
            }
            return $btn;
        })
            ->rawColumns(['action','status_now','file','timeline'])
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
    public function reset_material(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',1)->where('status_pengadaan',1)->where('state',2)->delete();
    }
    public function reset_operasional(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',2)->where('status_pengadaan',1)->where('state',2)->delete();
    }
    public function reset_jasa(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',3)->where('status_pengadaan',1)->where('state',2)->delete();
    }
    public function tampil_jasa(request $request)
    {
        $act='';
        $mtr=HeaderProject::where('id',$request->id)->first();
        $sum=0;
        $sumtotal=0;
        foreach(get_jasa_kontrak($request->id) as $no=>$o){
            $sum+=$o->biaya;
            $sumtotal+=$o->total;
            
                $act.='
                <tr style="background:#fff">
                    <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>';
                    if($mtr->status_id==9){
                        $act.='<td style="padding: 2px 2px 2px 8px;"><span class="btn btn-danger btn-xs" onclick="delete_jasa('.$o->id.')"><i class="fa fa-close"></i></span></td>';
                    }else{
                        $act.='<td style="padding: 2px 2px 2px 8px;"><span class="btn btn-default btn-xs" ><i class="fa fa-close"></i></span></td>';
                    }
                    $act.='
                        
                </tr>';
             
            
        }
        
        $act.='
        <tr style="background:#fff">
            <td colspan="2" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;">Total (Rp)</td>
            <td style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sum).'</td>
            <td style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right"></td>
            <td style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sumtotal).'</td>
            <td style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right"></td>
        </tr>';
       
        
        return $act;
    }
    public function tampil_operasional(request $request)
    {
        $act='';
        $mtr=HeaderProject::where('id',$request->id)->first();
        $sum=0;
        $sumtotal=0;
        foreach(get_operasional_kontrak($request->id) as $no=>$o){
            $sum+=$o->biaya;
            $sumtotal+=$o->total;
            
                $act.='
                <tr style="background:#fff">
                    <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>';
                    if($mtr->status_id==9){
                        $act.='<td style="padding: 2px 2px 2px 8px;"><span class="btn btn-danger btn-xs" onclick="delete_operasional('.$o->id.')"><i class="fa fa-close"></i></span></td>';
                    }else{
                        $act.='<td style="padding: 2px 2px 2px 8px;"><span class="btn btn-default btn-xs" ><i class="fa fa-close"></i></span></td>';
                    }
                    $act.='
                        
                </tr>';
             
            
        }
        
        $act.='
        <tr style="background:#fff">
            <td colspan="2" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;">Total (Rp)</td>
            <td style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sum).'</td>
            <td style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right"></td>
            <td style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sumtotal).'</td>
            <td style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right"></td>
        </tr>';
       
        
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
        $id=$request->id;
        
        $data=ProjectMaterial::where('id',$id)->delete();
    }
    public function delete_jasa(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('id',$id)->delete();
    }
    public function store_kontrak(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['customer_code']= 'required';
        $messages['customer_code.required']= 'Pilih  customer ';
        if($request->id==0){
            $rules['cost_center_project']= 'required';
            $messages['cost_center_kontrak.required']= 'Masukan Cost Center ';
        }
        

        $rules['kategori_project_id']= 'required';
        $messages['kategori_project_id.required']= 'Pilih  Kategori Project ';
       
        $rules['tipe_project_id']= 'required';
        $messages['tipe_project_id.required']= 'Pilih  Tipe Project ';

        $rules['deskripsi_project']= 'required';
        $messages['deskripsi_kontrak.required']= 'Masukan Ruang Lingkup Project';
        
        $rules['start_date']= 'required';
        $messages['start_date.required']= 'Masukan start date ';

        $rules['nik_pm']= 'required';
        $messages['nik_pm.required']= 'Pilih  project manager ';

        $rules['end_date']= 'required';
        $messages['end_date.required']= 'Masukan end date ';

        $rules['nilai_project']= 'required|min:0|not_in:0';
        $messages['nilai_kontrak.required']= 'Masukan nilai project ';
        $messages['nilai_kontrak.not_in']= 'Masukan nilai project ';
        
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
                
                
                $data=HeaderProject::create([
                    'customer_code'=>$request->customer_code,
                    'cost_center_project'=>$request->cost_center_project,
                    'nik_pm'=>$request->nik_pm,
                    'status_pengadaan_id'=>1,
                    'status_kontrak_id'=>0,
                    'progres_pengadaan'=>1,
                    'deskripsi_project'=>$request->deskripsi_project,
                    'start_date'=>$request->start_date,
                    'kategori_project_id'=>$request->kategori_project_id, 
                    'tipe_project_id'=>$request->tipe_project_id, 
                    'end_date'=>$request->end_date,
                    'nilai_project'=>ubah_uang($request->nilai_project),
                    'username'=>Auth::user()->username,
                    'active'=>1,
                    'tab'=>1,
                    'status_id'=>9,
                    'create'=>date('Y-m-d H:i:s'),
                    'update'=>date('Y-m-d H:i:s'),
                    'approve_kadis_komersil'=>date('Y-m-d H:i:s'),
                    'approve_kadis_operasional'=>date('Y-m-d H:i:s'),
                    'approve_mgr_operasional'=>date('Y-m-d H:i:s'),
                    'approve_direktur_operasional'=>date('Y-m-d H:i:s'),
                    'approve_kadis_operasional_kontrak'=>date('Y-m-d H:i:s'),
                ]);
                
                echo'@ok@'.encoder($data->id);
                   
                
            }else{
                $mst=HeaderProject::where('id',$request->id)->first();
                
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'customer_code'=>$request->customer_code,
                    'deskripsi_project'=>$request->deskripsi_project,
                    'nik_pm'=>$request->nik_pm,
                    'start_date'=>$request->start_date,
                    'kategori_project_id'=>$request->kategori_project_id,
                    'tipe_project_id'=>$request->tipe_project_id, 
                    'end_date'=>$request->end_date,
                    'nilai_project'=>ubah_uang($request->nilai_project),
                    'username'=>Auth::user()->username,
                    'create'=>date('Y-m-d H:i:s'),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                
                echo'@ok@'.encoder($request->id);
                
            }
           
        }
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
        $messages['deskripsi_kontrak.required']= 'Masukan Ruang Lingkup Project';
        
        $rules['start_date']= 'required';
        $messages['start_date.required']= 'Masukan start date ';

        $rules['end_date']= 'required';
        $messages['end_date.required']= 'Masukan end date ';

        $rules['nilai_project']= 'required|min:0|not_in:0';
        $messages['nilai_kontrak.required']= 'Masukan nilai project ';
        $messages['nilai_kontrak.not_in']= 'Masukan nilai project ';
        
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
        if($request->id==0){
            $rules['isiana']= 'required';
            $messages['isiana.required']= 'Lengkapi kolom kontrak ';
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
                    'status_id'=>10,
                    'update'=>date('Y-m-d H:i:s'),
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
    
    public function store_import_material(request $request){
        error_reporting(0);
        $id=$request->id;
        $rules = [];
        $messages = [];
        $rules['file_excel_material']= 'required';
        $messages['file_excel_material.required']= 'Harap isi upload excel';
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
            $mst=HeaderProject::where('id',$id)->first();
            if($mst->tab>2){
                $tab=$mst->tab;
            }else{
                $tab=4;
            }
            $filess = $request->file('file_excel_material');
            $nama_file = 'MATERIAL'.$id.'-'.rand().$filess->getClientOriginalName();
            $filess->move('public/file_excel',$nama_file);
            Excel::import(new ImportMaterialKontrak($id), public_path('/file_excel/'.$nama_file));
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
    
    public function store_operasional(request $request){
        error_reporting(0);
        $id=$request->id;
        $rules = [];
        $messages = [];
        if($id==0){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Harap isi rencana kerja terlebih dahulu';
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
            $count=(int) count($request->keterangan);
            if($count>0){
                $cek=0;
                for($x=0;$x<$count;$x++){
                    if($request->keterangan[$x]==""  && ($request->biayaopr[$x]=="" || ubah_uang($request->biayaopr[$x])) && ($request->qtyopr[$x]=="") || (ubah_uang($request->qtyopr[$x]))==0){
                        $cek+=0;
                    }else{
                        $cek+=1;
                    }
                }
                
                if($cek==$count){
                    $mst=HeaderProject::where('id',$id)->first();
                    if($mst->tab>1){
                        $tab=$mst->tab;
                    }else{
                        $tab=3;
                    }
                    $header=HeaderProject::where('id',$id)->update(['tab'=>$tab]);
                    for($x=0;$x<$count;$x++){
                        
                            
                            $data=ProjectMaterial::UpdateOrcreate([
                                'project_header_id'=>$id,
                                'nama_material'=>$request->keterangan[$x],
                                'kategori_ide'=>2,
                                'status'=>1,
                                'state'=>2,
                                
                            ],[
                                'biaya'=>ubah_uang($request->biayaopr[$x]),
                                'biaya_actual'=>ubah_uang($request->biayaopr[$x]),
                                'qty'=>ubah_uang($request->qtyopr[$x]),
                                'status_pengadaan'=>1,
                                'total'=>(ubah_uang($request->biayaopr[$x])*ubah_uang($request->qtyopr[$x])), 
                                'kode_material'=>$kode_material, 
                                'total_actual'=>(ubah_uang($request->biayaopr[$x])*ubah_uang($request->qtyopr[$x])), 
                                'satuan_material'=>'Item',
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
        }    
        
    }
    public function store_jasa(request $request){
        error_reporting(0);
        $id=$request->id;
        $rules = [];
        $messages = [];
        if($id==0){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Harap isi rencana kerja terlebih dahulu';
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
            $count=(int) count($request->keteranganjasa);
            if($count>0){
                $cek=0;
                for($x=0;$x<$count;$x++){
                    if($request->keteranjasa[$x]==""  && ($request->biayajasa[$x]=="" || ubah_uang($request->biayajasa[$x])) && ($request->qtyjasa[$x]=="") || (ubah_uang($request->qtyjasa[$x]))==0){
                        $cek+=0;
                    }else{
                        $cek+=1;
                    }
                }
               
                if($cek==$count){
                    $mst=HeaderProject::where('id',$id)->first();
                    if($mst->tab>1){
                        $tab=$mst->tab;
                    }else{
                        $tab=3;
                    }
                    $header=HeaderProject::where('id',$id)->update(['tab'=>$tab]);
                    for($x=0;$x<$count;$x++){
                        
                            
                            $data=ProjectMaterial::UpdateOrcreate([
                                'project_header_id'=>$id,
                                'nama_material'=>$request->keteranganjasa[$x],
                                'kategori_ide'=>3,
                                'status'=>1,
                                'state'=>2,
                                
                            ],[
                                'biaya'=>ubah_uang($request->biayajasa[$x]),
                                'biaya_actual'=>ubah_uang($request->biayajasa[$x]),
                                'qty'=>ubah_uang($request->qtyjasa[$x]),
                                'status_pengadaan'=>1,
                                'total'=>(ubah_uang($request->biayajasa[$x])*ubah_uang($request->qtyjasa[$x])), 
                                'kode_material'=>0, 
                                'total_actual'=>(ubah_uang($request->biayajasa[$x])*ubah_uang($request->qtyjasa[$x])), 
                                'satuan_material'=>'Item',
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
        }    
        
    }
    public function store_material_kontrak(request $request){
        error_reporting(0);
        $id=$request->id;
        $rules = [];
        $messages = [];
        if($id==0){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Harap isi rencana kerja terlebih dahulu';
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
            $count=(int) count($request->kode_material);
            if($count>0){
                $cek=0;
                for($x=0;$x<$count;$x++){
                    if($request->kode_material[$x]==""  || $request->qty[$x]=="" || $request->status_material_id[$x]==""   || $request->total[$x]=="" || $request->total[$x]==0){
                        $cek+=0;
                    }else{
                        $cek+=1;
                    }
                }

                if($cek==$count){
                    if($mst->tab>2){
                        $tab=$mst->tab;
                    }else{
                        $tab=4;
                    }
                    $header=HeaderProject::where('id',$id)->update(['tab'=>$tab]);
                    for($x=0;$x<$count;$x++){
                        
                            $data=ProjectMaterial::UpdateOrcreate([
                                'project_header_id'=>$id,
                                'kode_material'=>$request->kode_material[$x],
                                'status_material_id'=>$request->status_material_id[$x],
                                'status'=>1,
                                
                            ],[
                                'biaya'=>ubah_uang($request->biaya[$x]),
                                'biaya_actual'=>ubah_uang($request->biaya[$x]),
                                'qty'=>ubah_uang($request->qty[$x]),
                                'status_pengadaan'=>1,
                                'total'=>ubah_uang($request->total[$x]),
                                'total_actual'=>ubah_uang($request->total[$x]),
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
        }
        
               
        
        
    }
    public function store_material(request $request){
        error_reporting(0);
        $id=$request->id;
        $rules = [];
        $messages = [];
        if($id==0){
            $rules['catatan']= 'required';
            $messages['catatan.required']= 'Harap isi rencana kerja terlebih dahulu';
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
            $count=(int) count($request->kode_material);
            if($count>0){
                $cek=0;
                for($x=0;$x<$count;$x++){
                    if($request->qty[$x]==""  || $request->satuan_material[$x]=="" || $request->total[$x]=="" || $request->total[$x]==0){
                        $cek+=0;
                    }else{
                        $cek+=1;
                    }
                }

                if($cek==$count){
                    $mst=HeaderProject::where('id',$id)->first();
                    if($mst->tab>2){
                        $tab=$mst->tab;
                    }else{
                        $tab=4;
                    }
                    $header=HeaderProject::where('id',$id)->update(['tab'=>$tab]);
                    for($x=0;$x<$count;$x++){
                            if($request->kode_material[$x]==""){
                                $kode_material=0;
                            }else{
                                $kode_material=$request->kode_material[$x];
                            }
                            $data=ProjectMaterial::UpdateOrcreate([
                                'project_header_id'=>$id,
                                'nama_material'=>$request->nama_material[$x],
                                'kategori_ide'=>1,
                                'status'=>1,
                                'state'=>2,
                                
                            ],[
                                'biaya'=>ubah_uang($request->biaya[$x]),
                                'biaya_actual'=>ubah_uang($request->biaya[$x]),
                                'qty'=>ubah_uang($request->qty[$x]),
                                'status_pengadaan'=>1,
                                'total'=>ubah_uang($request->total[$x]), 
                                'kode_material'=>$kode_material, 
                                'total_actual'=>ubah_uang($request->total[$x]),
                                'nama_material'=>$request->nama_material[$x],
                                'satuan_material'=>$request->satuan_material[$x],
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
        
        if(count_material($request->id)==0){
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

    public function cetak(Request $request)
    {
        error_reporting(0);
        $id=decoder($request->id);
        $data=ViewHeaderProject::where('id',$id)->first();
        // $ford=3;
        $pdf = PDF::loadView('kontrak.cetak', compact('data'));
        // $custom=array(0,0,500,400);
        $pdf->setPaper('A4','portrait');
        $pdf->stream($request->id.'.pdf');
        return $pdf->stream();
    }
}
