<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAset extends Model
{
    use HasFactory;
    protected $table = 'status_aset';
    protected $guarded = ['id'];
    public $timestamps = false;
    
}
