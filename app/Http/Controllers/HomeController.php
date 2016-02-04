<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	protected $request;

    public function __construct(Request $request){
    	$this->request = $request;
    }

    public function index() {

    	return view('home');
    }
}
