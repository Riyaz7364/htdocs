<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
   protected $fillable = ['username','email','password','active','_token'];
   public $timestamps = false;
}
