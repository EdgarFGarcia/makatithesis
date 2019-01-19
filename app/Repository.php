<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Hash;

use Auth;

use Illuminate\Support\Collection;
use DataTables;

class Repository extends Model
{
    //
    public static function saveCustomerInfo($data, $date){
        
    	$username = $data->firstname . $data->lastname;
    	$password = Hash::make($username);

    	$query = DB::connection('mysql')
    	->table('users')
    	->insertGetId([
    		'username' => $username,
    		'firstname' => $data->firstname,
    		'middlename' => $data->middlename,
    		'lastname' => $data->lastname,
    		'phonenumber' => $data->phonenumber,
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
    		'created_at' => DB::raw("NOW()")
    	]);

    	return array($query, $query2);
    }

    //create an appointment inner
    public static function appointmentInner($data, $date){
        return $query = DB::connection('mysql')
        ->table('appointments')
        ->insert([  
            'user_id' => $data->user_id,
            'from' => $date,
            'created_at' => DB::raw("NOW()")
        ]);
    }

    // get appointment admin
    public static function loadAppointment(){
        $query = DB::connection('mysql')
        ->table('appointments as a')

        ->select(
            DB::raw("CONCAT(b.lastname, ', ', b.firstname, ' ', b.middlename) as name"),
            'a.from as appointment',
            'a.is_approved as approved',
            'a.is_done as done',
            'a.id as appointmentId',
            'b.id as userId'
        )

        ->join('users as b', 'a.user_id', '=', 'b.id')

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

            $data[] = $obj;
        }

        $info = new Collection($data);
        return DataTables::of($info)->make(true);
    }

    public static function loadTableUser($data){

        $query = DB::connection('mysql')
        ->table('appointments')
        ->select('*')
        ->where('user_id', $data->user_id)
        ->get();

        $data = array();

        foreach($query as $out){
            $obj = new \stdClass;

            $obj->date = $out->from;
            $obj->approved = $out->is_approved;
            $obj->done = $out->is_done;

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
}
