<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository;
use App\Model\AppointmentType;

use Auth;
use Redirect;
use Hash;
use \DateTime;
use Calendar;

class MainController extends Controller
{
    //
	//login
	public function login(Request $r){
		// return $r->all();
        // return $hashedpassword = Hash::make($r->password);
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
        return redirect('/');
	}

    // get appointment type
    public function getAppointmentType(){
        $query = AppointmentType::getAppointmentType();
        if($query){
            return response()->json([
                'query' => $query
            ]);
        }
    }

    // check availability of the date
    public function checkdate(Request $r){
        $dateToCheck = date('Y-m-d', strtotime($r->appointment));
        $time = date('H:i:s', strtotime($r->appointment));

        $checkAvailability = Repository::checkAvailability($dateToCheck);

        if($checkAvailability[0]->count == 0){
            return response()->json([
                'response' => true,
                'message' => "Three (3) Slots are available"
            ]);
        }else if($checkAvailability[0]->count == 1){
            return response()->json([
                'response' => true,
                'message' => "Two (2) Slots are available"
            ]);
        }else if($checkAvailability[0]->count == 2){
            return response()->json([
                'response' => true,
                'message' => "One (1) Slot is available"
            ]);
        }else{
            return response()->json([
                'response' => false,
                'message' => "Fully Booked"
            ]);
        }
    }

	// make an appointment
    public function appoint(Request $r){
        // return $r->all();
        $dateTocheck = date('Y-m-d', strtotime($r->appointment));
        
    	$validateData = $r->validate([
    		'firstname' => 'required|string',
    		'middlename' => 'required|string',
    		'lastname' => 'required|string',
    		'mobilenumber' => 'required|unique:users',
    	]);

        $check = Repository::checkAppointment($dateTocheck);

        if(count($check) >= 3){
            return response()->json([
                'message' => "Scheduling for this day is already full",
                'response' => false
            ]);
        }

    	$date = date('Y-m-d', strtotime($r->appointment));
        $time = date('H:i:s', strtotime($r->appointment));
        $whole = date('Y-m-d H:i:s', strtotime($r->appointment));
    	$query = Repository::saveCustomerInfo($r, $date, $time, $whole);
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

    // make an appointment inner
    public function appointmentInner(Request $r){
        // return $r->all();
        $dateTocheck = date('Y-m-d', strtotime($r->appointment));
        $check = Repository::checkAppointment($dateTocheck);

        if(count($check) >= 3){
            return response()->json([
                'message' => "Scheduling for this day is already full",
                'response' => false
            ]);
        }

        $date = date('Y-m-d H:i:s', strtotime($r->appointment));
        $time = date('H:i:s', strtotime($r->appointment));
        $whole = date('Y-m-d H:i:s', strtotime($r->appointment));

        $query = Repository::appointmentInner($r, $date, $time, $whole);

        if($query){
            return response()->json([
                'message' => 'Appointment Successful',
                'response' => $query
            ]);
        }else{
            return response()->json([
                'message' => "There's An Error!",
                'response' => array()
            ]);
        }

    }

    // payment
    public function payment(Request $r){
        // return $r->data['user_id'];
        // return $r->all();
        $query = Repository::payment($r->data['date']);
        if($query){
            return response()->json([
                'response' => true,
                'query' => $query
            ]);
        }
    }

    // make payment
    public function makepayment(Request $r){
        // return $r->all();
        $paymentDate = $r->paymentid;
        $mode = $r->modeofpayment;
        $query = Repository::makepayment($mode, $paymentDate);

        if($query){
            return response()->json([
                'response' => true,
                'message' => "Payment Succesful"
            ]);
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
                'title' => $out->lastname . ", " . $out->firstname . " " . $out->middlename,
                'id' => $out->id,
                'end' => $out->from,
                'start' => $out->from
            );
        }
        return json_encode($all);
    }

    // sales
    public function getSales(){
        $query = Repository::getSales();

        return json_encode($query);
    }

    // edit profile
    public function editprofile(Request $r){
        // changepassword, user_id
        if(!empty($r->changepassword)){
            $query = Repository::editprofile($r);
            if($query){
                return response()->json([
                    'message' => "Changing Password Successful",
                    'response' => $query
                ], 200);
            }else{
                return response()->json([
                    'message' => "There's an error editing your profile",
                    'response' => array()
                ], 403);
            }
        }

        return false;
    }
}
