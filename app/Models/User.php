<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use Config;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type_id',
    ];

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

    public function isSuperAdminLoggedIn()
    {
        if (Auth::user()->user_type_id == Config::get("constants.UserTypeIds.SuperAdmin")) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdminLoggedIn()
    {
        if (Auth::user()->user_type_id == Config::get("constants.UserTypeIds.Admin")) {
            return true;
        } else {
            return false;
        }
    }

    public function isCompanyLoggedIn()
    {
        if (Auth::user()->user_type_id == Config::get("constants.UserTypeIds.Company")) {
            return true;
        } else {
            return false;
        }
    }

    public function isUserLoggedIn()
    {
        if (Auth::user()->user_type_id == Config::get("constants.UserTypeIds.User")) {
            return true;
        } else {
            return false;
        }
    }

    public function GetProfilePic()
    {
        if (Auth::user()->user_type_id == Config::get("constants.UserTypeIds.User")) {

            return $this->UserDetail->profile_pic != null ? $this->UserDetail->profile_pic : 'img/default.png';
        }
        if (Auth::user()->user_type_id == Config::get("constants.UserTypeIds.Company")) {

            return $this->CompanyDetail->profile_pic != null ? $this->CompanyDetail->profile_pic : 'img/default.png';
        }
        if (Auth::user()->user_type_id == Config::get("constants.UserTypeIds.Admin")) {

            return 'img/default.png';
        }
        if (Auth::user()->user_type_id == Config::get("constants.UserTypeIds.SuperAdmin")) {

            return 'img/default.png';
        }

    }


    public function UserType()
    {
        return $this->belongsTo('App\Models\User_type','user_type_id');
    }


}
