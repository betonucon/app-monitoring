<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesstoken extends Model
{
    use HasFactory;
    protected $table = 'personal_access_tokens';
    public $timestamps = false;
    // protected $fillable = [ 
    //     'helpdesk_id',
    //     'file',
    //     'create',
    //     'tipe'
    // ];
    // function mkategori(){
    //     return $this->belongsTo('App\Models\Mannouncement','kategori_announcement_id','id');
    // }
}
