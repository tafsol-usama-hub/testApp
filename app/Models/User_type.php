<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
	public $table = "user_types";
	protected $guarded = [];

	// public function User(){
 //      return $this->belongsTo('App\Models\User','user_id');
 //    }
}
