<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
   protected $table='admins';

   protected $fillable=['name','email','uname','user_type','password'];

    public $timestamps = false;

   
}
