<?php

function get_jabatan(){
    $data=App\Models\Jabatan::orderBy('id','Asc')->get();
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
function get_status(){
    $data=App\Models\Viewstatus::orderBy('id','Asc')->get();
    return $data;
}
function get_status_board($id){
    if($id==1){
        $data=App\Models\Viewstatus::whereBetween('id',[1,4])->orderBy('id','Asc')->get();
    }
    if($id==2){
        $data=App\Models\Viewstatus::whereBetween('id',[5,8])->orderBy('id','Asc')->get();
    }
    if($id==3){
        $data=App\Models\Viewstatus::whereBetween('id',[9,11])->orderBy('id','Asc')->get();
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
function notifikasi_side(){
    if(Auth::user()->role_id==1){
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',array())->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==2){
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',array(5))->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==3){
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',array(4))->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==4){
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',array(2))->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==5){
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',array(3))->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==6){
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',array())->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==7){
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',array(3))->count();
        if($coun>0){
            return '<span class="pull-right-container">
                        <span class="label label-primary pull-right">'.$coun.'</span>
                    </span>';
        }else{
            return "";
        }
    }
    if(Auth::user()->role_id==8){
        $coun=App\Models\ViewHeaderProject::whereIn('status_id',array())->count();
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
        $data=App\Models\HeaderProject::count();
    }
    if($id==2){
        $data=App\Models\HeaderProject::whereBetween('status_id',[1,8])->count();
    }
    if($id==3){
        $data=App\Models\HeaderProject::whereBetween('status_id',[9,11])->count();
    }
    if($id==4){
        $data=App\Models\HeaderProject::whereBetween('status_id',[12,13])->count();
    }
    if($id==5){
        $data=App\Models\HeaderProject::where('status_id',13)->count();
    }
    if($id==6){
        $data=App\Models\HeaderProject::whereBetween('status_id',[14,15])->count();
    }
    if($id==7){
        $data=App\Models\HeaderProject::where('status_id',50)->count();
    }
    
    return $data;
}
function get_status_event(){
    if(Auth::user()->role_id==1){
        $data=App\Models\Viewstatus::whereBetween('id',[1,18])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==2){
        $data=App\Models\HeaderProject::whereBetween('status_id',[5,18])->count();
    }
    if(Auth::user()->role_id==3){
        $data=App\Models\Viewstatus::whereBetween('id',[1,4])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==4){
        $data=App\Models\Viewstatus::whereBetween('id',[2,18])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==5){
        $data=App\Models\Viewstatus::whereBetween('id',[3,18])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==6){
        $data=App\Models\Viewstatus::whereBetween('id',[1,18])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==7){
        $data=App\Models\Viewstatus::whereBetween('id',[3,18])->orderBy('id','Asc')->get();
    }
    if(Auth::user()->role_id==8){
        $data=App\Models\Viewstatus::whereBetween('id',[1,4])->orderBy('id','Asc')->get();
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
            $data='<li><a href="javascript:;" onclick="location.assign(`'.url('project/view').'?id='.encoder($id).'`)">View</a></li>';
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

?>