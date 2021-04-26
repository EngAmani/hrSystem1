<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amana_id',
        'company_id',
        'Administration',
        'role',
        'leaveBalance',
        'emergencyLesve',
        'name',
        'email',
        'password',
    ];

    public function isCheckedIn(){
        $dt = Carbon::now();
       // $dt->toDateString();
        $checkedIn = Auth::user()->posts->where('date',$dt->toDateString())->where('time_out',null)->count();
    //dd($checkedIn,empty($checkedIn));
        if($checkedIn == 0){
            return false;
        }else{
            return true;
        }
        
    }
    public function passedLimit(){
        $limit = 3; 
        $dt = Carbon::now();
        $count_attends = Auth::user()->posts->where('date',$dt->toDateString())->where('time_out','<>',null)->where('time_in','<>',null)->count();
        return $limit <= $count_attends;
    }
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
 protected $table="users";
   public function posts(){
       return $this->hasMany(Post::class);
   }

   public function shifts(){
       return $this->hasOne(Shift::class);
   }



}
