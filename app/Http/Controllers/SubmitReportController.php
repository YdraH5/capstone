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
    public function index(){
        return view('renters.report');
    }

    
public function create(Request $request) {
    $data = $request->validate([
        'report_category' => ['required', 'string', 'max:50'], 
        'description' => ['required', 'max:250'],
        'user_id' => ['required', 'numeric'],
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
