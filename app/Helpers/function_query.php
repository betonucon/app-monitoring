<?php

function get_jabatan(){
    $data=App\Models\Jabatan::orderBy('id','Asc')->get();
    return $data;
}
function get_master_operasional(){
    $data=App\Models\Operasional::orderBy('operasional','Asc')->get();
    return $data;
}
function get_kategori_stok(){
    $data=App\Models\StokKategori::orderBy('id','Asc')->get();
    return $data;
}
function get_periode($id){
    $data=App\Models\ViewProjectperiode::where('project_header_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function deskripsi_alasan($id,$status_id){
    $cek=App\Models\LogPengajuan::where('project_header_id',$id)->where('status_id',$status_id)->where('revisi',2)->count();
    if($cek>0){
        $data=App\Models\LogPengajuan::where('project_header_id',$id)->where('status_id',$status_id)->orderBy('id','Desc')->firstOrfail();
        return $data->deskripsi;
    }else{
        return "0";
    }
    
}
function get_personal($id){
    $data=App\Models\ViewPersonal::where('project_header_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function get_status_material(){
    $data=App\Models\Statusmaterial::orderBy('id','Asc')->get();
    return $data;
}
function sum_personal($id){
    $data=App\Models\ViewPersonal::where('project_header_id',$id)->sum('biaya');
    return $data;
}

//------material rencana------------------------------------//
function get_operasional($id){
    $data=App\Models\ViewProjectMaterial::where('state',1)->where('project_header_id',$id)->where('kategori_ide',2)->orderBy('nama_material','Asc')->get();
    return $data;
}
function sum_biaya_operasional($id){
    $data=App\Models\ViewProjectMaterial::where('state',1)->where('project_header_id',$id)->where('kategori_ide',2)->sum('total');
    return $data;
}
function sum_biaya_jasa($id){
    $data=App\Models\ViewProjectMaterial::where('state',1)->where('project_header_id',$id)->where('kategori_ide',3)->sum('total');
    return $data;
}
function get_jasa($id){
    $data=App\Models\ViewProjectMaterial::where('state',1)->where('project_header_id',$id)->where('kategori_ide',3)->orderBy('nama_material','Asc')->get();
    return $data;
}
function sum_biaya_material($id){
    $data=App\Models\ViewProjectMaterial::where('state',1)->where('project_header_id',$id)->where('kategori_ide',1)->sum('total');
    return $data;
}
function get_material($id){
    $data=App\Models\ViewProjectMaterial::where('state',1)->where('project_header_id',$id)->where('kategori_ide',1)->orderBy('nama_material','Asc')->get();
    return $data;
}

//------material kontrak------------------------------------//
function get_operasional_kontrak($id){
    $data=App\Models\ViewProjectMaterial::where('state',2)->where('project_header_id',$id)->where('kategori_ide',2)->orderBy('nama_material','Asc')->get();
    return $data;
}
function sum_biaya_operasional_kontrak($id){
    $data=App\Models\ViewProjectMaterial::where('state',2)->where('project_header_id',$id)->where('kategori_ide',2)->sum('total');
    return $data;
}
function sum_biaya_jasa_kontrak($id){
    $data=App\Models\ViewProjectMaterial::where('state',2)->where('project_header_id',$id)->where('kategori_ide',3)->sum('total');
    return $data;
}
function get_jasa_kontrak($id){
    $data=App\Models\ViewProjectMaterial::where('state',2)->where('project_header_id',$id)->where('kategori_ide',3)->orderBy('nama_material','Asc')->get();
    return $data;
}
function sum_biaya_material_kontrak($id){
    $data=App\Models\ViewProjectMaterial::where('state',2)->where('project_header_id',$id)->where('kategori_ide',1)->sum('total');
    return $data;
}
function get_material_kontrak($id){
    $data=App\Models\ViewProjectMaterial::where('state',2)->where('project_header_id',$id)->where('kategori_ide',1)->orderBy('nama_material','Asc')->get();
    return $data;
}
function get_material_kontrak_ready($id){
    $data=App\Models\ViewProjectMaterial::where('state',2)->where('project_header_id',$id)->where('kategori_ide',1)->orderBy('status_pengadaan','Asc')->get();
    return $data;
}
function get_material_project($id){
    $data=App\Models\ViewProjectMaterial::where('project_header_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function count_material_project($id){
    $data=App\Models\ViewProjectMaterial::where('project_header_id',$id)->sum('total');
    return uang($data);
}
function count_biaya_project($id){
    $data=App\Models\ProjectOperasional::where('project_header_id',$id)->sum('biaya');
    return uang($data);
}
function get_biaya_project($id){
    $data=App\Models\ProjectOperasional::where('project_header_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function get_risiko_project($id){
    $data=App\Models\ProjectRisiko::where('project_header_id',$id)->orderBy('id','Asc')->get();
    return $data;
}
function count_material_verfikasi($id){
    $data=App\Models\ViewProjectMaterial::where('project_header_id',$id)->where('status',2)->orderBy('id','Asc')->get();
    return $data;
}
function count_material($id){
    $data=App\Models\ProjectMaterial::where('project_header_id',$id)->count();
    return $data;
}
function count_material_verifikasi($id){
    $data=App\Models\ProjectMaterial::where('project_header_id',$id)->where('status_material_id','>',0)->count();
    return $data;
}
function count_material_pengadaan($id){
    $data=App\Models\ProjectMaterial::where('project_header_id',$id)->where('status_material_id',1)->count();
    return $data;
}
function sum_operasional($id){
    $data=App\Models\ProjectOperasional::where('project_header_id',$id)->sum('biaya');
    return $data;
}
function sum_material($id){
    $data=App\Models\ProjectMaterial::where('project_header_id',$id)->sum('total');
    return $data;
}
function get_job(){
    $data=App\Models\Job::where('id','!=',1)->orderBy('id','Asc')->get();
    return $data;
}
function get_kategori(){
    $data=App\Models\Kategori::orderBy('id','Asc')->get();
    return $data;
}
function get_tipe(){
    $data=App\Models\Tipe::orderBy('id','Asc')->get();
    return $data;
}
function get_role(){
    $data=App\Models\Role::where('id','!=',1)->orderBy('id','Asc')->get();
    return $data;
}
function get_risiko($id){
    $data=App\Models\ProjectRisiko::where('project_header_id',$id)->orderBy('urut','Asc')->get();
    return $data;
}
function get_satuan(){
    $data=App\Models\Satuan::orderBy('satuan','Asc')->get();
    return $data;
}
function get_status_task(){
    $data=App\Models\StatusTask::orderBy('id','Asc')->get();
    return $data;
}
function get_progres_task(){
    $data=App\Models\StatusProgres::orderBy('id','Asc')->get();
    return $data;
}
function get_progres_project(){
    $data=App\Models\ViewHeaderProjectcontrol::where('status_id',9)->where('total_task_progres','!=',100)->orderBy('id','Asc')->get();
    return $data;
}
function get_customer_project(){
    $data=App\Models\ViewCustomerProject::orderBy('customer','Asc')->get();
    return $data;
}
function get_status_aset(){
    $data=App\Models\StatusAset::orderBy('id','Asc')->get();
    return $data;
}
function count_pm(){
    $data=App\Models\HeaderProject::where('nik_pm',Auth::user()->username)->count();
    return $data;
}
function get_status(){
    $data=App\Models\Viewstatus::orderBy('id','Asc')->get();
    return $data;
}
function get_status_risiko(){
    $data=App\Models\Statusrisiko::orderBy('id','Asc')->get();
    return $data;
}
function get_status_board($id){
    if($id==1){
        $data=App\Models\Viewstatus::whereBetween('id',[1,3])->orderBy('id','Asc')->get();
    }
    if($id==2){
        $data=App\Models\Viewstatus::whereBetween('id',[4,6])->orderBy('id','Asc')->get();
    }
    if($id==3){
        $data=App\Models\Viewstatus::whereIn('id',array(7,50))->orderBy('id','Asc')->get();
    }
    if($id==4){
        $data=App\Models\Viewstatus::whereBetween('id',[8,11])->orderBy('id','Asc')->get();
    }
    if($id==5){
        $data=App\Models\Viewstatus::whereBetween('id',[12,15])->orderBy('id','Asc')->get();
    }
    if($id==6){
        $data=App\Models\Viewstatus::whereBetween('id',[16,17])->orderBy('id','Asc')->get();
    }
    
    return $data;
}
function get_employe_even($role_id){
    $data=App\Models\Employe::where('role_id',$role_id)->orderBy('id','Asc')->get();
    return $data;
}
function count_status_project($status_id){
    $data=App\Models\ViewHeaderProject::where('status_id','>',$status_id)->where('active',1)->count();
    return $data;
}
function count_all_project(){
    $data=App\Models\ViewHeaderProject::where('active',1)->count();
    return $data;
}
function get_all_project(){
    $data=App\Models\ViewHeaderProject::where('active',1)->where('status_id','<',9)->orderBy('id','Asc')->get();
    return $data;
}
function get_all_project_cancel(){
    $data=App\Models\ViewHeaderProject::where('active',1)->where('status_id',50)->orderBy('id','Asc')->get();
    return $data;
}
function notifikasi_side($act){
    if(Auth::user()->role_id==1){
        if($act==2){
            $array=array();
        }else{
            $array=array();
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==2){
        if($act==2){
            $array=array();
        }else{
            $array=array(5);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==3){
        if($act==2){
            $array=array();
        }else{
            $array=array(4);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==4){
        if($act==2){
            $array=array();
        }else{
            $array=array(2);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==5){
        if($act==2){
            $array=array();
        }else{
            $array=array(3);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==6){
        if($act==2){
            $array=array(1,7,8);
        }else{
            $array=array(1,7,8);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==7){
        if($act==2){
            $array=array();
        }else{
            $array=array(3);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==8){
        if($act==2){
            $array=array(9);
        }else{
            $array=array();
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    
}
function notifikasi_side_kontrak($act){
    if(Auth::user()->role_id==1){
        if($act==2){
            $array=array();
        }else{
            $array=array();
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==2){
        if($act==2){
            $array=array();
        }else{
            $array=array(5);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==3){
        if($act==2){
            $array=array();
        }else{
            $array=array(4);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==4){
        if($act==2){
            $array=array();
        }else{
            $array=array(2);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==5){
        if($act==2){
            $array=array();
        }else{
            $array=array(3);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==6){
        if($act==2){
            $array=array(8,9);
        }else{
            $array=array(0);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_kontrak_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==7){
        if($act==2){
            $array=array();
        }else{
            $array=array(3);
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==8){
        if($act==2){
            $array=array(9);
        }else{
            $array=array();
        }
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',$array)->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    
}
function count_project($id){
    if($id==1){
        $data=App\Models\ViewHeaderProjectcontrol::where('status_id',9)->count();
    }
    if($id==2){
        $data=App\Models\ViewHeaderProjectcontrol::where('status_id',9)->where('total_task_progres','<',100)->count();
    }
    if($id==3){
        $data=App\Models\ViewHeaderProjectcontrol::where('status_id',9)->where('total_task_progres','!=',100)->where('end_date','<',date('Y-m-d'))->count();
    }
    if($id==4){
        $data=App\Models\ViewHeaderProjectcontrol::where('status_id',9)->where('total_task_progres',100)->count();
    }
    if($id==5){
        $data=App\Models\ViewHeaderProjectcontrol::where('status_id',13)->count();
    }
    if($id==6){
        $data=App\Models\ViewHeaderProjectcontrol::where('status_id',9)->count();
    }
    if($id==7){
        $data=App\Models\ViewHeaderProjectcontrol::where('status_id',50)->count();
    }
    
    return $data;
}
function get_status_event(){
    if(Auth::user()->role_id==1){
        $data=App\Models\Viewstatus::whereBetween('id',[1,8])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==2){
        $data=App\Models\HeaderProject::whereBetween('status_id',[5,8])->count();
    }
    if(Auth::user()->role_id==3){
        $data=App\Models\Viewstatus::whereBetween('id',[1,4])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==4){
        $data=App\Models\Viewstatus::whereBetween('id',[2,8])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==5){
        $data=App\Models\Viewstatus::whereBetween('id',[3,8])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==6){
        $data=App\Models\Viewstatus::whereBetween('id',[1,8])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==7){
        $data=App\Models\Viewstatus::whereBetween('id',[3,8])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==8){
        $data=App\Models\Viewstatus::whereBetween('id',[1,4])->orderBy('id','Asc')->get();
    }
    
    return $data;
}

function get_status_event_kontrak(){
    if(Auth::user()->role_id==1){
        $data=App\Models\Viewstatus::whereBetween('id',[9,11])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==2){
        $data=App\Models\HeaderProject::whereBetween('id',[9,11])->count();
    }
    if(Auth::user()->role_id==3){
        $data=App\Models\Viewstatus::whereBetween('id',[9,11])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==4){
        $data=App\Models\Viewstatus::whereBetween('id',[9,11])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==5){
        $data=App\Models\Viewstatus::whereBetween('id',[9,11])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==6){
        $data=App\Models\Viewstatus::whereBetween('id',[9,11])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==7){
        $data=App\Models\Viewstatus::whereBetween('id',[9,11])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==8){
        $data=App\Models\Viewstatus::whereBetween('id',[9,11])->orderBy('id','Asc')->get();
    }
    
    return $data;
}
function tombol_act($id,$status_id){
    
    
    if(Auth::user()->role_id==1){
        if($status_id==1){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==2){
        if($status_id==5){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==3){
        if($status_id==4){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==4){
        if($status_id==2){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==5){
        if($status_id==3){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==6){
        if($status_id==1){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }else{
           
            if($status_id==7){
                $data.='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">Konfirmasi Bidding</a></li>';
            }elseif($status_id==8){
                $data.='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">Konfirmasi Negosiasi</a></li>';
            }else{
                $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
            }
        }
    }
    if(Auth::user()->role_id==7){
        if($status_id==3){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==8){
        if($status_id==1){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    return $data;
}
function tombol_kontrak_act($id,$status_kontrak_id){
    
    
    if(Auth::user()->role_id==1){
        if($status_kontrak_id==1){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">View</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==2){
        if($status_kontrak_id==5){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==3){
        if($status_kontrak_id==4){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==4){
        if($status_kontrak_id==2){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==5){
        if($status_kontrak_id==3){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==6){
        if($status_kontrak_id==1){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">Penyusunan Kontrak</a></li>';
        }else{
           
            if($status_kontrak_id==6){
                $data.='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">Konfirmasi Bidding</a></li>';
            }elseif($status_kontrak_id==7){
                $data.='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">Konfirmasi Negosiasi</a></li>';
            }else{
                $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">View</a></li>';
            }
        }
    }
    if(Auth::user()->role_id==7){
        if($status_kontrak_id==10){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">Approve & Konfirmasi</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    if(Auth::user()->role_id==8){
        if($status_kontrak_id==11){
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">Create Pengadaan</a></li>';
        }else{
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('kontrak/view').'?id='.encoder($id).'`)">View</a></li>';
        }
    }
    return $data;
}
?>