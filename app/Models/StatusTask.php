<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTask extends Model
{
    use HasFactory;
    protected $table = 'status_task';
    protected $guarded = ['id'];
    public $timestamps = false;
    
}
