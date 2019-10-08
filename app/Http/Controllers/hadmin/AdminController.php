<?php

namespace App\Http\Controllers\Hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index(){
    	return view('hadmin.admin.index');
    }
    public function index_v1(){
    	return view('hadmin.admin.index_v1');
    }
}
