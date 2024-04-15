<?php

namespace App\Livewire;
use App\Models\Report;
use Livewire\Component;
use Livewire\Attributes\Validate; 
use Illuminate\Support\Facades\DB;
class ReportTable extends Component
{
    public $search = "";
    public Report $selectedReport;

    #[Validate('required|min:5|max:50')] 
    public $status = '';
    public $id;
    public function edit($id){
        $this->id = $id;
    }
    public function action()
    {
        $this->validate([
            'status' => 'required|min:5|max:50',
        ]);
        $update = DB::table('reports')
                    ->where('id', $this->id)
                    ->update(['status' => $this->status]);
            if ($update) {
                $this->reset(); // Reset the component if the update was successful
                 return redirect()->route('admin.reports.index')->with('success', 'Report Action submitted successfully');
                } else {
                    return redirect()->back()->withInput()->withErrors(['status' => 'Failed to update status']); 
            }                
    }
    public function render()
    {
        $report = new Report();
        return view('livewire.report.report-table', [
            'reports' => $report->search($this->search),
        ]);
    }
}
