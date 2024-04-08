<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubmitReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function home(){
        return view('renters.home');
    }
    public function index(){
        return view('renters.report.index');
    }
}
