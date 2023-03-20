<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Arahkan ke Index
    public function index(){
       return view('dashboard');
    }
}
 