<?php

function get_jabatan(){
    $data=App\Models\Jabatan::orderBy('id','Asc')->get();
    return $data;
}
function get_role(){
    $data=App\Models\Role::where('id','!=',1)->orderBy('id','Asc')->get();
    return $data;
}

?>