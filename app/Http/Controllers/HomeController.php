<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    /**
     * Show the welcome view 
     * @return \Illimunate\View\View
     */
    public function index(){
        return view('welcome'); 
    }
}
