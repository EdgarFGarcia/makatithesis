<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Hash;

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
}
