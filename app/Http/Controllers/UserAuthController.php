<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Account;
use Session;
use PHPMailer\PHPMailer;

class UserAuthController extends Controller
{
    public  function signup(Request $request){
    	
    	// Form Validation 	
    	$this->validate($request,[
    		'email' => 'required|email',
    		'password' =>'required|confirmed'
    	]);

    	// Check if user already exits and verifed account or not
	if(Account::where('email',$request->get('email'))->exists()){
    	 $sql = DB::select('select * from accounts where email = ?', [$request->input('email')]);
    	 foreach ($sql as $row) {
    	 if($row->active == 1){
    	 	Session::flash('message','Email already exits!');
    		Session::flash('alert-class', 'error'); 
    		return redirect('register');
    		 }
    	  }
		}

    	$rand_token = md5(rand(0,999999)); // Generate rendom string for verification link
    	$sql = new Account([
    		'username'	=>	$request->input('username'),
    		'email'		=>	$request->input('email'),
    		'password'	=>	$request->input('password'),
    		'active'	=> 	0,
    		'_token'	=>	$rand_token
    	]);

    	$sql->save();  // Insert the query

    	// PHP Mailer to send verification mail
    	$text             = 'Follow link to confirm your email <a href="http://localhost/confirm/'.$rand_token.'">Click Here</a>';
        $mail             = new PHPMailer\PHPMailer(); // create a n
        $mail->isSMTP();
        $mail->SMTPDebug  = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 587; // or 587
        $mail->IsHTML(true);
        $mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
			)
		);
        $mail->Username = "xxxxxxxx@gmail.com";
        $mail->Password = "xxxxxxxxxxx";
        $mail->SetFrom("noreply@gmail.com", 'Support');
        $mail->Subject = "Verify your account!";
        $mail->Body    = $text;
        $mail->AddAddress($request->input('email'), $request->input('username'));
        if ($mail->Send()) {

        Session::flash('user_unique_id', $sql->id);	
    	session(['email'=>$request->input('email'), 'username'=> $request->input('username'), 'user_unique_id'=>$sql->id]);
    	   Session::flash('message','Verification link send to your email!');
    		Session::flash('alert-class', 'success'); 
    		return redirect('register');

        } else {

            Session::flash('message','Fail to send verification link!');
    		Session::flash('alert-class', 'error'); 
    		return redirect('register');

        }
    	return redirect('/');
    }


  
    public function login(Request $request){

    	$this->validate($request,['email' => 'required|email']);

    	if(Account::where('email',$request->get('email'))->exists()){

   		 $sql = DB::select('select * from accounts where email = ?', [$request->input('email')]);
    
    	foreach ($sql as $row) {
    		if($row->active == 1){
    		if($request->input('password') == $row->password){ 			
    		session(['email'=>$row->email,'username'=>$row->username,'user_unique_id'=>$row->id]);
    		}else{
	    		Session::flash('message','Wrong password!');
	    		Session::flash('alert-class', 'error'); 
	    		return redirect('login');
	    			 }
    		}else{
    		Session::flash('message','Email not exists!');
    		Session::flash('alert-class', 'error'); 
    		return redirect('login');
    	}
    	}
    		return redirect('/');
    	}else{
    		Session::flash('message','Email is not exists!');
    		Session::flash('alert-class', 'error'); 
    		return redirect('login');
    	}
    }


    public function confirm(Request $request){

    	if(Account::where('_token',$request->token)->exists()){
    		DB::table('accounts')->where('_token',$request->token)->update(['_token'=>'true','active'=>1]);

    		Session::flash('message','Email verify success!');
    		Session::flash('alert-class', 'success'); 
    		return redirect('login');
    	}else{
    		Session::flash('message','Link expired!');
    		Session::flash('alert-class', 'error'); 
    		return redirect('register');
    	}
}


	public function resetPassword(Request $request){

		$this->validate($request,['password'=>'required|confirmed']);

		DB::table('accounts')->where('email',Session::get('email'))->update(['password'=>$request->input('password')]);
			Session::flash('message','Password Chage success, Relogin!');
    		Session::flash('alert-class', 'success'); 
    		return redirect('login');
	}
}
