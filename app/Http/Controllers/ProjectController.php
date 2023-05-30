<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Imports\ImportMaterial;
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
use App\Models\ProjectPeriode;
use App\Models\ProjectMaterial;
use App\Models\ProjectPersonal;
use App\Models\ViewProjectMaterial;
use App\Models\ProjectRisiko;
use App\Models\ProjectOperasional;
use App\Models\Material;
use App\Models\LogPengajuan;
use App\Models\ViewCost;
use App\Models\User;
use PDF;
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
        }elseif(Auth::user()->role_id==7){
            return view('project.index_operasional',compact('template'));
        }elseif(Auth::user()->role_id==5){
            return view('project.index_procurement',compact('template'));
        }elseif(Auth::user()->role_id==2){
            return view('project.index_direktur_operasional',compact('template'));
        }elseif(Auth::user()->role_id==3){
            return view('project.index_mgr_operasional',compact('template'));
        }else{
            return view('error');
        }
        
    }
    public function cetak(Request $request)
    {
        error_reporting(0);
        $id=decoder($request->id);
        $data=ViewHeaderProject::where('id',$id)->first();
        // $ford=3;
        $pdf = PDF::loadView('project.cetak', compact('data'));
        // $custom=array(0,0,500,400);
        $pdf->setPaper('A4','portrait');
        $pdf->stream($request->id.'.pdf');
        return $pdf->stream();
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
        
        if($id>0){
            $disabled='readonly';
            $connomor=ProjectRisiko::where('project_header_id',$id)->count();
            $connomoropr=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',2)->where('state',1)->count();
            $connomorjasa=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',3)->where('state',1)->count();
            $connomormat=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',1)->where('state',1)->count();
            $nom=($connomor+1);
            $nomper=($connomoropr+1);
            $nommat=($connomormat+1);
            $nomjasa=($connomorjasa+1);

            
        }else{
            $disabled='';
            $nom=1;
            $nomper=1;
            $nomjasa=1;
            $nommat=1;
        }
        dd($nomjasa);
        if(Auth::user()->role_id==6){
            if($data->status_id==1){
                return view('project.view_data',compact('template','data','disabled','id','nom','nomper','nommat','tab','nomjasa'));
            }else{
                if($id==0){
                    return view('project.view_data',compact('template','data','disabled','id','nom','nomper','nommat','tab','nomjasa'));
                }else{
                    if($data->status_id==7){
                        return view('project.view_bidding',compact('template','data','disabled','id'));
                    }elseif($data->status_id==8){
                        return view('project.view_negosiasi',compact('template','data','disabled','id'));
                    }else{
                        return view('project.view',compact('template','data','disabled','id'));
                    }
                    
                }
                
            }
        }
        if(Auth::user()->role_id==4){
            if($data->status_id==2){
                return view('project.view_approve_komersil',compact('template','data','disabled','id'));
            }else{
                return view('project.view',compact('template','data','disabled','id'));
                
            }
        }
        if(Auth::user()->role_id==7){
            if($data->status_id==3){
                return view('project.view_approve_operasional',compact('template','data','disabled','id'));
            }else{
                return view('project.view',compact('template','data','disabled','id'));
                
            }
        }
        if(Auth::user()->role_id==3){
            if($data->status_id==4){
                return view('project.view_approve_mgr_operasional',compact('template','data','disabled','id'));
            }else{
                return view('project.view',compact('template','data','disabled','id'));
                
            }
        }
        if(Auth::user()->role_id==2){
            if($data->status_id==5){
                return view('project.view_approve_direktur_operasional',compact('template','data','disabled','id'));
            }else{
                return view('project.view',compact('template','data','disabled','id'));
                
            }
        }
        if(Auth::user()->role_id==5){
            if($data->status_id==6){
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
    public function form_material(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=$request->id;
        
        $data=ViewProjectMaterial::where('id',$id)->first();
        return view('project.form_material',compact('template','data','id'));
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
                $data = $query->where('status_id','>',5);
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
                $data = $query->where('status_id','>',3);
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
        $data = $query->where('status_id','!=',9)->orderBy('id','Desc')->get();

        return Datatables::of($data)
            ->addColumn('seleksi', function ($row) {
                $btn='<span class="btn btn-success btn-xs" onclick="pilih_cost(`'.$row->cost_center.'`,`'.$row->customer_code.'`,`'.$row->customer.'`,`'.$row->deskripsi_project.'`)">Pilih</span>';
                return $btn;
            })
            ->addColumn('action', function ($row) {
                if(Auth::user()->role_id==1){

                }
                if(Auth::user()->role_id==2){
                    if($row->status_id==5){
                        $color='success';
                    }else{
                        $color='default';
                    }
                }
                if(Auth::user()->role_id==3){
                    if($row->status_id==4){
                        $color='success';
                    }else{
                        $color='default';
                    }
                }
                if(Auth::user()->role_id==4){
                    if($row->status_id==2){
                        $color='success';
                    }else{
                        $color='default';
                    }
                }
                if(Auth::user()->role_id==5){
                    if($row->status_id==6){
                        $color='success';
                    }else{
                        $color='default';
                    }
                }
                if(Auth::user()->role_id==6){
                    if(in_array($row->status_id, array(1,7,8))){
                        $color='success';
                    }else{
                        $color='default';
                    }
                }
                if(Auth::user()->role_id==7){
                    if($row->status_id==3){
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
                                    if($row->status_id==1){
                                        $btn.='
                                        <li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($row->id).'`)">View</a></li>
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
                    $btn='<font color="#000" style="font-style:italic"><b>'.$row->singkatan.'</b></font>';
                
                }else{
                    $btn='<font color="#000" style="font-style:italic"><b>Penyusunan</b></font>';
                }
                return $btn;
            })
            
            ->rawColumns(['action','seleksi','status_now','file','timeline'])
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

    public function tampil_operasional(request $request)
    {
        $act='';
        $mtr=HeaderProject::where('id',$request->id)->first();
        $sum=0;
        $sumtotal=0;
        foreach(get_operasional($request->id) as $no=>$o){
            $sum+=$o->biaya;
            $sumtotal+=$o->total;
            
                $act.='
                <tr style="background:#fff">
                    <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>';
                    if($mtr->status_id==1){
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
    public function tampil_jasa(request $request)
    {
        $act='';
        $mtr=HeaderProject::where('id',$request->id)->first();
        $sum=0;
        $sumtotal=0;
        foreach(get_jasa($request->id) as $no=>$o){
            $sum+=$o->biaya;
            $sumtotal+=$o->total;
            
                $act.='
                <tr style="background:#fff">
                    <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>';
                    if($mtr->status_id==1){
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

    public function tampil_material(request $request)
    {
        if($request->id>0){
             $act='';
            $mtr=HeaderProject::where('id',$request->id)->first();
            $sum=0;
            $sumact=0;
            $data=HeaderProject::where('id',$request->id)->first();
            $status=$data->status_id;
            
                foreach(get_material($request->id,1) as $no=>$o){
                    $sum+=$o->total;
                    
                        $act.='
                        <tr style="background:#fff" >
                            <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                            <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                            <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                            <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                            <td style="padding: 2px 2px 2px 8px;">'.$o->satuan_material.'</td>
                            <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>';
                            if($mtr->status_id==1){
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
    public function tampil_material_in(request $request)
    {
        $act='';
        $sum=0;
        foreach(get_material($request->id,2) as $no=>$o){
            $sum+=$o->total;
            if($request->act==1){
                $act.='
                <tr style="background:#fff">
                    <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->kode_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                    
                    <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>
                </tr>';
            }else{
                $act.='
                <tr style="background:#fff" >
                    <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->kode_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>
                    <td style="padding: 2px 2px 2px 8px;"><span class="btn btn-danger btn-xs" onclick="delete_material('.$o->id.')"><i class="fa fa-close"></i></span></td>
                        
                </tr>';
            }
            
        }
        if($request->act==1){
        $act.='
        <tr style="background:#fff">
            <td colspan="5" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;">Total (Rp)</td>
            <td style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sum).'</td>
        </tr>';
        }else{
        $act.='
        <tr style="background:#fff">
            <td colspan="5" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;">Total (Rp)</td>
            <td colspan="2" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sum).'</td>
        </tr>';
        }
        
        return $act;
    }
    public function tampil_material_proc(request $request)
    {
        $act='';
        $sum=0;
        $sumact=0;
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
            if($request->act==1){
                $act.='
                <tr style="background:#fff">
                    <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->kode_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya_actual).'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>
                    <td style="padding: 2px 2px 2px 8px;background:'.$clr.'" class="text-center" >'.$o->st_material.'</td>
                </tr>';
            }else{
                
                $act.='
                <tr style="background:#fff" >
                    <td style="padding: 2px 2px 2px 8px;">'.($no+1).'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->kode_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->nama_material.'</td>
                    <td style="padding: 2px 2px 2px 8px;">'.$o->qty.'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya).'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->biaya_actual).'</td>
                    <td style="padding: 2px 2px 2px 8px;" class="text-right">'.uang($o->total).'</td>
                    <td style="padding: 2px 2px 2px 8px;background:'.$clr.'" class="text-center" >'.$o->st_material.'</td>';
                    if($o->status_material_id>0){
                        $act.='
                        <td style="padding: 2px 2px 2px 8px;">
                            <span class="btn btn-success btn-xs" onclick="update_material('.$o->id.')"><i class="fa fa-search"></i></span>
                        </td>';
                    }else{
                        $act.='
                        <td style="padding: 2px 2px 2px 8px;">
                            <span class="btn btn-info btn-xs" onclick="update_material('.$o->id.')"><i class="fa fa-search"></i></span>
                        </td>';
                    }
                    $act.='
                        
                </tr>';
            }
            
        }
       
        $act.='
        <tr style="background:#fff">
            <td colspan="4" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;">Total (Rp)</td>
            <td colspan="2" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sum).'</td>
            <td colspan="2" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right">'.uang($sumact).'</td>
            <td colspan="2" style="padding: 6px 2px 6px 8px;background: #d9cece;font-weight: bold;" class="text-right"></td>
        </tr>';
        
        
        return $act;
    }
    public function store_procurement(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        if(count_material($request->id)!=count_material_verifikasi($request->id)){
            $rules['status_material_id']= 'required';
            $messages['status_material_id.required']= 'Harap verifikasi semua material ';
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
                $data=HeaderProject::where('id',$request->id)->update([
                    'approve_procurement'=>date('Y-m-d H:i:s'),
                    'status_id'=>7,
                ]);
                if($request->status_id==50){
                    $revisi=2;
                }else{
                    $revisi=1;
                }
                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$request->hasil_bidding,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>$revisi,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
        }
               
        
        
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

    public function tampil_risiko_view(request $request)
    {
        $act='';
        foreach(get_risiko($request->id) as $no=>$o){
            $act.='
            <tr style="background:#fff ">
                <td>'.($no+1).'</td>
                <td>'.$o->risiko.'</td>
                <td>'.$o->status_risiko.'</td>
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

    public function delete_operasional(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('id',$id)->delete();
    }
    public function delete_jasa(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('id',$id)->delete();
    }

    public function delete_material(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('id',$id)->delete();
    }
    public function reset_material(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',1)->where('state',1)->delete();
    }
    public function reset_operasional(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',2)->where('state',1)->delete();
    }
    public function reset_jasa(request $request)
    {
        $id=$request->id;
        
        $data=ProjectMaterial::where('project_header_id',$id)->where('kategori_ide',3)->where('state',1)->delete();
    }
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['customer_code']= 'required';
        $messages['customer_code.required']= 'Pilih  customer ';

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
            if($request->id=='0'){
                
                
                $data=HeaderProject::create([
                    'customer_code'=>$request->customer_code,
                    'deskripsi_project'=>$request->deskripsi_project,
                    'start_date'=>$request->start_date,
                    'kategori_project_id'=>$request->kategori_project_id, 
                    'tipe_project_id'=>$request->tipe_project_id, 
                    'end_date'=>$request->end_date,
                    'nilai_project'=>ubah_uang($request->nilai_project),
                    'nilai'=>ubah_uang($request->nilai_project),
                    'username'=>Auth::user()->username,
                    'active'=>1,
                    'tab'=>1,
                    'status_id'=>1,
                    'create'=>date('Y-m-d H:i:s'),
                ]);
                foreach(get_master_operasional($request->kategori_project_id) as $opr){
                    $operasional=ProjectOperasional::UpdateOrcreate([
                        'project_header_id'=>$data->id,
                        'keterangan'=>$opr->operasional,
                    ],[
                        'biaya'=>0,
                        'status_operasional'=>0,
                    ]);
                }
                echo'@ok@'.encoder($data->id);
                   
                
            }else{
                $mst=HeaderProject::where('id',$request->id)->first();
                if($mst->kategori_project_id!=$request->kategori_project_id){
                    foreach(get_master_operasional($request->kategori_project_id) as $opr){
                        $operasional=ProjectOperasional::UpdateOrcreate([
                            'project_header_id'=>$request->id,
                            'keterangan'=>$opr->operasional,
                        ],[
                            'status_operasional'=>0,
                        ]);
                    }
                }else{

                }
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'customer_code'=>$request->customer_code,
                    'deskripsi_project'=>$request->deskripsi_project,
                    'start_date'=>$request->start_date,
                    'kategori_project_id'=>$request->kategori_project_id,
                    'tipe_project_id'=>$request->tipe_project_id, 
                    'end_date'=>$request->end_date,
                    'nilai_project'=>ubah_uang($request->nilai_project),
                    'nilai'=>ubah_uang($request->nilai_project),
                    'username'=>Auth::user()->username,
                    'active'=>1,
                    'status_id'=>1,
                    'create'=>date('Y-m-d H:i:s'),
                ]);
                
                
                echo'@ok@'.encoder($request->id);
                
            }
           
        }
    }
    
   
    public function publish(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['customer_code']= 'required';
        $messages['customer_code.required']= 'Pilih  customer ';

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
                    'kategori_project_id'=>$request->kategori_project_id,
                    'tipe_project_id'=>$request->tipe_project_id,
                    'end_date'=>$request->end_date,
                    'username'=>Auth::user()->username,
                    'active'=>1,
                    'status_id'=>2,
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>'Pengajuan telah dipublish dan dikirim kekadis operasional',
                    'status_id'=>2,
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
                                'state'=>1,
                                
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
                                'state'=>1,
                                
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

    public function store_risiko(request $request){
        error_reporting(0);
        $id=$request->id;
        $rules = [];
        $messages = [];
        if($id==0){
            $rules['risiko']= 'required';
            $messages['risiko.required']= 'Harap isi rencana kerja terlebih dahulu';
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
            $count=(int) count($request->risiko);
            if($count>0){
                $cek=0;
                for($x=0;$x<$count;$x++){
                    if($request->risiko[$x]==""  || $request->status_risiko[$x]==""){
                        $cek+=0;
                    }else{
                        $cek+=1;
                    }
                }

                if($cek==$count){
                    
                        $tab=5;
                    
                    $header=HeaderProject::where('id',$id)->update(['tab'=>$tab]);
                    for($x=0;$x<$count;$x++){
                        
                            $data=ProjectRisiko::UpdateOrcreate([
                                'project_header_id'=>$id,
                                'risiko'=>$request->risiko[$x],
                            ],[
                                'status_risiko'=>$request->status_risiko[$x],
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
                                'state'=>1,
                                
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
            Excel::import(new ImportMaterial($id), public_path('/file_excel/'.$nama_file));
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
    public function verifikasi_material(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['biaya_actual']= 'required|min:0|not_in:0';
        $messages['biaya_actual.required']= 'Masukan nilai actual ';
        $messages['biaya_actual.not_in']= 'Masukan nilai actual ';

        $rules['status_material_id']= 'required';
        $messages['status_material_id.required']= 'Pilih  status material ';
       

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
                $data=ProjectMaterial::UpdateOrcreate([
                    'id'=>$request->id,
                    
                ],[
                    'biaya_actual'=>ubah_uang($request->biaya_actual),
                    'total_actual'=>(ubah_uang($request->biaya_actual)*$mst->qty),
                    'status_material_id'=>$request->status_material_id,
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

    
    public function store_bidding(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['nilai_bidding']= 'required|min:0|not_in:0';
        $messages['nilai_bidding.required']= 'Masukan nilai bidding';
        $messages['nilai_bidding.not_in']= 'Masukan nilai bidding';
        
        $rules['terbilang']= 'required';
        $messages['terbilang.required']= 'Masukan terbilang';
       
        
        $rules['bidding_date']= 'required';
        $messages['bidding_date.required']= 'Masukan tanggal bidding';

        $rules['status_id']= 'required';
        $messages['status_id.required']= 'Masukan status';

        $rules['hasil_bidding']= 'required';
        $messages['hasil_bidding.required']= 'Masukan hasil bidding';
        

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
                $mstr=HeaderProject::find($request->id);
                $data=HeaderProject::UpdateOrcreate([
                    'id'=>$request->id,
                ],[
                    'status_id'=>$request->status_id,
                    'cost_center_project'=>penomoran_cost_center($mstr->customer_code),
                    'bidding_date'=>$request->bidding_date,
                    'hasil_bidding'=>$request->hasil_bidding,
                    'nilai_bidding'=>ubah_uang($request->nilai_bidding),
                    'nilai_project'=>ubah_uang($request->nilai_bidding),
                    'update'=>date('Y-m-d H:i:s'),
                ]);

                if($request->status_id==50){
                    $revisi=2;
                }else{
                    $revisi=1;
                }
                $detail=ProjectMaterial::where('project_header_id',$request->id)->where('state',1)->get();
                if($request->status_id==9){
                    foreach($detail as $o){
                        $save=ProjectMaterial::UpdateOrcreate([
                            'project_header_id'=>$request->id,
                            'nama_material'=>$o->nama_material,
                            'status'=>$o->status,
                            'kategori_ide'=>$o->kategori_ide,
                            'state'=>2,
                        ],[
                            'biaya'=>$o->biaya,
                            'kode_material'=>0,
                            
                            'satuan_material'=>$o->satuan_material,
                            'biaya_actual'=>$o->biaya_actual,
                            'qty'=>$o->qty,
                            'status_pengadaan'=>$o->status_pengadaan,
                            'total'=>$o->total,
                            'total_actual'=>$o->total_actual,
                            'created_at'=>date('Y-m-d H:i:s'),
                        ]);
                    }
                }
                $log=LogPengajuan::create([
                    'project_header_id'=>$request->id,
                    'deskripsi'=>$request->hasil_bidding,
                    'status_id'=>$request->status_id,
                    'nik'=>Auth::user()->username,
                    'role_id'=>Auth::user()->role_id,
                    'revisi'=>$revisi,
                    'created_at'=>date('Y-m-d H:i:s'),
                ]);
                echo'@ok';
        }
               
        
        
    }

    public function store_negosiasi(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        
        $rules['nilai_negosiasi']= 'required|min:0|not_in:0';
        $messages['nilai_negosiasi.required']= 'Masukan nilai kontrak';
        $messages['nilai_negosiasi.not_in']= 'Masukan nilai kontrak';
        

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
                    'status_id'=>9,
                    'status_kontrak_id'=>1,
                    'nilai_project'=>ubah_uang($request->nilai_negosiasi),
                    'nilai'=>$mst->nilai_project,
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
}
