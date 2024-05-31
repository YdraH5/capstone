<?php

namespace App\Http\Controllers;
use App\Models\Report;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SubmitReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function home(){
        return view('renters.payment');
    }
    public function index(Request $request){
        $userId = $request->user()->id;
        do {
            $ticket = Str::random(10);
            $existingTicket = DB::table('reports')->where('ticket', $ticket)->exists();
        } while ($existingTicket);
        $reports = DB::table('reports')
        ->join('users', 'users.id', '=', 'reports.user_id')
        ->select('users.name','reports.id', 'reports.report_category', 'reports.description','reports.status','reports.ticket',(DB::raw('DATE_FORMAT(reports.created_at, "%b-%d-%Y") as date')))
        ->where('reports.user_id', $userId)
        ->get();
        return view('renters.report',['reports'=>$reports,'ticket'=>$ticket]);
        }
    
public function create(Request $request) {
    $data = $request->validate([
        'report_category' => ['required', 'string', 'max:50'], 
        'description' => ['required', 'max:250'],
        'user_id' => ['required', 'numeric'],
        'ticket' => ['required']
    ]);

    $userId = $request->user()->id;
    $count = DB::table('reports')
        ->where('user_id', $userId)
        ->count();

    if ($count < 3) {
        $newReport = Report::create($data);
        return redirect()->route('renters.report')->with('success', 'Reports added successfully');
    } else {
        return redirect()->route('renters.report.index')->with('failed', 'Sorry, you have reached the maximum number of reports. Please wait for other reports to be solved.');
    }
}
    public function view(int $report_id){
        $report = DB::table('reports')
        ->where('id',$report_id)
        ->get();
        return view('renters.report.index',['views'=>$report]);
    }
}
