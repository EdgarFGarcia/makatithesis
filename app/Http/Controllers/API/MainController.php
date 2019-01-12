<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository;
use Carbon\Carbon;

use Auth;
use Redirect;

class MainController extends Controller
{
    //
	//login
	public function login(Request $r){
		// return $r->all();
		$credentials = $r->only('username', 'password');

		if(Auth::attempt($credentials)){
			return redirect()->intended('home');
		}else{
			return redirect()->intended('welcome');
		}
	}

	// logout
	public function logout(){
		Auth::logout();
		return redirect()->intended('welcome');
	}

	// make an appointment
    public function appoint(Request $r){

    	$validateData = $r->validate([
    		'firstname' => 'required|string',
    		'middlename' => 'required|string',
    		'lastname' => 'required|string',
    		'mobilenumber' => 'required|unique:users',
    	]);

    	$date = date('Y-m-d', strtotime($r->date));
    	$query = Repository::saveCustomerInfo($r, $date);
    	if($query){
    		return response()->json([
    			'message' => "Successfully Appointed",
    			'response' => $query
    		], 200);
    	}else{
    		return response()->json([
    			'message' => "There's An Error!",
    			'response' => array()
    		], 403);
    	}
    }
}
