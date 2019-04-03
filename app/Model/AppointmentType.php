<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppointmentType extends Model
{
    //
    protected $connection = "mysql";
    protected $table = "appointment_type";

    public static function getAppointmentType(){
    	return $query = AppointmentType::get();
    }
}
