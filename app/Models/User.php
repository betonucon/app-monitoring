<?php
  
namespace App\Models;
  
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
  
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
  
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function role(){
		return $this->belongsTo('App\Models\Role','role_id','id');
    }
    function roleutama(){
		return $this->belongsTo('App\Models\Role','role_utama','id');
    }
    // function person(){
	// 	return $this->belongsTo('App\Models\MContactPerson','person_id','id');
    // }
    // function guest(){
	// 	return $this->belongsTo('App\Models\Guestpersone','person_id','id');
    // }
}
