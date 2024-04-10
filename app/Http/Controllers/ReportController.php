<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{public function __construct()
    {
        $this->middleware('isAdmin');
    }
    
    public function index(Request $request){
        do {
            $ticket = Str::random(10);
            $existingTicket = DB::table('reports')->where('ticket', $ticket)->exists();
        } while ($existingTicket);
        $reports = DB::table('reports')
        ->join('users', 'users.id', '=', 'reports.user_id')
        ->select('users.name', 'reports.report_category', 'reports.description','reports.status','reports.ticket',(DB::raw('DATE_FORMAT(reports.created_at, "%b-%d-%Y") as date')))
        ->get();
        return view('admin.reports.index',['reports'=>$reports]);
    }
    
}
