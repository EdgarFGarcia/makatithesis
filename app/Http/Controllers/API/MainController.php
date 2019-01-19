<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository;

use Auth;
use Redirect;

use \DateTime;
use Calendar;

class MainController extends Controller
{
    //

    //index
    // public function index(){
    //     return view('welcome');
    // }

	//login
	public function login(Request $r){
		// return $r->all();
		$credentials = $r->only('username', 'password');

		if(Auth::attempt($credentials)){
			return redirect()->intended('/home');
		}else{
			return redirect('/');
		}
	}

	// logout
	public function logout(){
		Auth::logout();
		// return redirect()->intended('welcome');
        return;
	}

	// make an appointment
    public function appoint(Request $r){
    	$validateData = $r->validate([
    		'firstname' => 'required|string',
    		'middlename' => 'required|string',
    		'lastname' => 'required|string',
    		'mobilenumber' => 'required|unique:users',
    	]);

    	$date = date('Y-m-d H:i:s', strtotime($r->date));
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

    // load appointment
    public function loadAppointment(){
        return $query = Repository::loadAppointment();
    }

    // load data from appointment
    public function loadDataAppointment(Request $r){
        // return $r->data['appointmentId'];
        return $query = Repository::loadDataAppointment($r);

    }

    // approve appointment
    public function approveAppointment(Request $r){
        // return $r->appointId;
        return $query = Repository::approveAppointment($r);

    }

    public function approveAppointmentDone(Request $r){
        return $query = Repository::approveAppointmentDone($r);
    }

    // load datatable user appointment
    public function loadTableUser(Request $r){
        // if(Auth::check()){
            return $query = Repository::loadTableUser($r);
        // }else{
            // return "nope";
        // }
        // return $query = Repository::loadTableUser();
    }

    // load my appointment
    public function loadMyAppointment(Request $r){

        $query = Repository::loadMyAppointment($r);

        $test = array();

        foreach($query as $out){

            $test[] = array(
                'allDay' => false,
                'title' => "Schedule",
                'id' => $out->id,
                'end'   => $out->from,
                'start' => $out->from,
            );

            
        }

        return json_encode($test);
    }

    public function sales(){
        return view('sales');
    }

    public function loadAllCalendar(){
        $query = Repository::loadAllCalendar();
        $all = array();
        foreach($query as $out){
            $all[] = array(
                'allDay' => false,
                'title' => $out->lastname . ", " . $out->firstname . " " . $out->lastname,
                'id' => $out->id,
                'end' => $out->from,
                'start' => $out->from
            );
        }

        return json_encode($all);
    }

    // sales
    public function getSales(){
        return $query = Repository::getSales();
        // $sales = array();
        // if($query){
        //     foreach($query as $out){
        //         $sales[] = array(
        //             'sales' => $out
        //         );
        //     }
        // }

        return json_encode($sales);
    }
}
