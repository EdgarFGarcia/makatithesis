<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $query = DB::connection('mysql')
        ->table('users')
        ->where('mobilenumber', Auth::User()->mobilenumber)
        ->first();

        return view('home')->with([
            'user_id' => Auth::User()->id
        ]);
    }
}
