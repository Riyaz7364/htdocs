<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;

class AccountManager extends Controller
{
    	function index($name, $lname = ''){

    		$account = new Account(['id'=>'5','name'=>'Riyaz']);
    		$account->save();

		echo "Name is ".$name.' '.$lname;
	}
}
