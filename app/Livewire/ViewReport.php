<?php

namespace App\Livewire;
use Livewire\Attributes\Validate; 
use App\Models\Report;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
class ViewReport extends Component
{
    use WithPagination;
    public $isViewing= false;
    public $id;
    public $search;
    public $viewReport;
    #[Validate('required|min:5|max:50')] 
    public $status;

    #[Validate('required|max:50')] 
    public $ticket;

    #[Validate('required|max:150')] 
    public $description;

    #[Validate('required')] 
    public $date;

    #[Validate('required')] 
    public $report_category;
    public function view($id){
        $this->isViewing= true;
        $this->id = $id;
        $this->viewReport = Report::find($id);
        $this->report_category = $this->viewReport->report_category;
        $this->status = $this->viewReport->status;
        $this->ticket = $this->viewReport->ticket;
        $this->description = $this->viewReport->description;
        $this->date = $this->viewReport->created_at;
    }
    public function render()
    {
        $user = Auth::user();

        $report =Report::where('user_id', $user->id)->get();
        return view('livewire.renter.view-report', [
            'reports' => $report,
        ]);
    }
}
