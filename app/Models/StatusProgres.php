<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusProgres extends Model
{
    use HasFactory;
    protected $table = 'status_progres';
    protected $guarded = ['id'];
    public $timestamps = false;
    
}
