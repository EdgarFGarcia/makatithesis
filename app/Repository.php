<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Hash;

use Auth;

use Illuminate\Support\Collection;
use DataTables;

use Nexmo;

use Carbon\Carbon;

class Repository extends Model
{
    //
    // check availability
    public static function checkAvailability($date){
        // return $date;
        return $query = DB::connection('mysql')
        ->table('appointments')
        ->select(
            DB::raw("COUNT(*) as count")
        )
        ->where('from', $date)
        ->where('is_approved', '=', 0)
        ->where('is_done', '=', 0)
        ->get();
    }

    // check appointment
    public static function checkAppointment($dateTocheck){
        return $query = DB::connection('mysql')
        ->table('appointments')
        ->select(
            DB::raw("COUNT(*) AS count")
        )
        ->where('from', $dateTocheck)
        ->get();

    }


    public static function saveCustomerInfo($data, $date, $time, $whole){

    	$username = $data->firstname . $data->lastname;
    	$password = Hash::make($username);
        // test changes
    	$query = DB::connection('mysql')
    	->table('users')
    	->insertGetId([
    		'username' => $username,
    		'firstname' => $data->firstname,
    		'middlename' => $data->middlename,
    		'lastname' => $data->lastname,
    		'bday' => $data->bday,
    		'mobilenumber' => $data->mobilenumber,
    		'email' => $data->emailaddress,
    		'password' => $password,
    		'position_id' => 1,
    		'created_at' => DB::raw("NOW()")
    	]);
    	// dd($query);
    	$query2 = DB::connection('mysql')
    	->table('appointments')
    	->insert([
    		'user_id' => $query,
    		'from' => $date,
            'time' => $time,
            'appointment' => $whole,
            'appointment_type' => $data->appointmentType,
    		'created_at' => DB::raw("NOW()")
    	]);

        $query3 = DB::connection('mysql')
        ->table('payment')
        ->insert([
            'user_id' => $query,
            'payment' => '900',
            'date' => $whole,
            'created_at' => DB::raw("NOW()"),
        ]);

    	return array($query, $query2, $query3);
    }

    //create an appointment inner
    public static function appointmentInner($data, $date, $time, $whole){
        $query = DB::connection('mysql')
        ->table('appointments')
        ->insert([  
            'user_id' => $data->user_id,
            'from' => $date,
            'time' => $time,
            'appointment' => $whole,
            'appointment_type' => $data->appointmentType,
            'created_at' => DB::raw("NOW()")
        ]);

        $query2 = DB::connection('mysql')
        ->table('payment')
        ->insert([
            'user_id' => $data->user_id,
            'payment' => '900',
            'date' => $whole,
            'created_at' => DB::raw("NOW()")
        ]);

        return array($query, $query2);
    }

    // payment
    public static function payment($date){
        return $query = DB::connection('mysql')
        ->table('payment')
        ->where('date', $date)
        // ->where('is_paid', 0)
        ->get();
    }

    public static function makepayment($mode, $paymentDate){
        return $query = DB::connection('mysql')
        ->table('payment')
        ->where('date', $paymentDate)
        ->update([
            'mode_of_payment' => $mode,
            'is_paid' => 1
        ]);
    }

    // get appointment admin
    public static function loadAppointment(){
        $query = DB::connection('mysql')

        ->table('appointments as a')

        ->select(
            DB::raw("CONCAT(b.lastname, ', ', b.firstname, ' ', b.middlename) as name"),
            'a.appointment as appointment',
            'a.is_approved as approved',
            'a.is_done as done',
            'a.id as appointmentId',
            'a.appointment_type as appointment_type',
            'b.id as userId',
            'c.is_paid as is_paid',
            'd.name as appointmentName'
        )

        ->join('users as b', 'a.user_id', '=', 'b.id')
        ->join('payment as c', 'a.user_id', '=', 'c.user_id')
        ->join('appointment_type as d', 'a.appointment_type', '=', 'd.id')

        ->where('a.is_done', 0)
        ->where('c.is_paid', 1)

        ->get();

        $data = array();

        foreach($query as $out){
            $obj = new \stdClass;

            $obj->appointmentId = $out->appointmentId;
            $obj->userId = $out->userId;
            $obj->name = $out->name;
            $obj->approved = $out->approved;
            $obj->done = $out->done;
            $obj->appointment = $out->appointment;
            $obj->is_paid = $out->is_paid;
            $obj->appointmentName = $out->appointmentName; 

            $data[] = $obj;
        }

        $info = new Collection($data);
        return DataTables::of($info)->make(true);
    }

    public static function loadTableUser($data){
        // return $data;
        $query = DB::connection('mysql')
        ->table('appointments as a')
        ->select(
            'a.user_id as user_id',
            'a.appointment as appointment',
            'a.is_approved as is_approved',
            'a.is_done as is_done',
            'b.name as appointmentName'
            // 'b.id as paymentId'
        )
        // ->join('payment as b', 'a.user_id', '=', 'b.user_id')
        ->join('appointment_type as b', 'a.appointment_type', '=', 'b.id')
        ->where('a.user_id', $data->user_id)
        ->get();

        $data = array();

        foreach($query as $out){
            $obj = new \stdClass;

            $obj->user_id = $out->user_id;
            $obj->date = $out->appointment;
            $obj->approved = $out->is_approved;
            $obj->done = $out->is_done;
            $obj->appointmentName = $out->appointmentName;
            // $obj->paymentId = $out->paymentId;

            $data[] = $obj;
        }

        $info = new Collection($data);
        return DataTables::of($info)->make(true);
    }

    public static function loadMyAppointment($data){

        return $query = DB::connection('mysql')

        ->table('appointments')

        ->select('*')

        ->where('user_id', $data->user_id)
        ->where('is_approved', 1)
        ->where('is_done', 0)

        ->get();

    }

    public static function loadAllCalendar(){
        return $query = DB::connection('mysql')
        ->table('appointments')
        ->select('*')
        ->join('users', 'appointments.user_id', '=', 'users.id')
        ->where('is_approved', 1)
        ->where('is_done', 0)
        ->get();
    }

    // load data from appointment
    public static function loadDataAppointment($data){
        $query = DB::connection('mysql')
        ->table('appointments')

        ->select(
            // '*'
            DB::raw("CONCAT(users.lastname, ', ', users.firstname, ' ', users.middlename) as name"),
            'appointments.from as appointment',
            'appointments.id as appointmentId'
        )

        ->join('users', 'appointments.user_id', '=', 'users.id')
        ->where('appointments.id', $data->data['appointmentId'])
        ->first();

        return $result = response()->json([
            'response' => $query 
        ]);

    }

    // approve appointment
    public static function approveAppointment($data){
        $query = DB::connection('mysql')
        ->table('appointments')
        ->where('id', $data->appointId)
        ->update([
            'is_approved' => 1,
            'updated_at' => DB::raw("NOW()")
        ]);

        $message = DB::connection('mysql')
        ->table('appointments')
        ->select('*')
        ->join('users', 'appointments.user_id', '=', 'users.id')
        ->where('appointments.id', $data->appointId)
        ->get();

        Nexmo::message()->send([
            'to' => $message[0]->mobilenumber,
            'from' => 'KABAKA',
            'text' => 'Your Appointment ' . $message[0]->from . ' Has been approved'
        ]);

    }

    //done appointment (nabunutan na)
    public static function approveAppointmentDone($data){
        $query = DB::connection('mysql')
        ->table('appointments')
        ->where('id', $data->appointId)
        ->update([
            'is_done' => 1,
            'updated_at' => DB::raw("NOW()")
        ]);
    }

    //sales
    public static function getSales(){
        return $query = DB::connection('mysql')
        ->table('appointments')
        ->select(
            DB::raw("COUNT(is_done) as 'count'")
        )
        ->where('is_done', 1)
        ->groupBy('created_at')
        ->get();
    }

    // edit profile
    public static function editprofile($data){
        $newpassword = Hash::make($data->changepassword);
        return $query = DB::connection('mysql')
        ->table('users')
        ->where('id', $data->user_id)
        ->update([
            'password' => $newpassword,
            'username' => $data->username,
            'firstname' => $data->firstname,
            'middlename' => $data->middlename,
            'lastname' => $data->lastname,
            'bday' => $data->bday,
            'mobilenumber' => $data->mobilenumber
        ]);
    }
}
