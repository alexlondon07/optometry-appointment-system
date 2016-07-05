<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
  	 * Show the application dashboard to the user.
  	 *
  	 * @return Response
  	 */
  	public function index()
  	{
  		return view('home');
  	}

  	public function main()
  	{
  		return view('main');
  	}
}
