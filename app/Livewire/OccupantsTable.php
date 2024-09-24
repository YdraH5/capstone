<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appartment;
use App\Models\Category;
use App\Models\Payment;
use App\Models\User;
use App\Models\DueDate;
use App\Models\Building;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class OccupantsTable extends Component
{
    use WithPagination;
    public $search;
    public $sortDirection="ASC";
    public $payment_due_date;
    public $sortColumn ="renters_name";
    public $perPage = 10;
    public $isSend= false;
    public $currentReceipt;
    public $currentStatus;
    public $modal = false;
    public $due_id;
    public function doSort($column){
        if($this->sortColumn === $column){
            $this->sortDirection = ($this->sortDirection === 'ASC')? 'DESC':'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }
    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search input is updated
    }
    public function isSend(){
        $this->isSend = true;
    }
    public function send()
    {
        $this->validate([
            'payment_due_date' => 'required'
        ]);
    
        // Get all apartments where the renter_id is set
        $apartments = DB::table('apartment')
            ->whereNotNull('renter_id')
            ->get();

        foreach ($apartments as $apartment) {
            $price = Category::find($apartment->category_id);
    
            // Get the renter associated with the apartment
            $renter = User::where('id', $apartment->renter_id)
                ->where('role', 'renter') // Only renters
                ->first();
    
            if ($renter) {
                // Check if the DueDate record already exists for the user and due date
                $dueDateExists = DueDate::where('user_id', $renter->id)
                    ->where('payment_due_date', $this->payment_due_date)
                    ->exists();
    
                if (!$dueDateExists) {
                    // Create a due_date record for the renter
                    DueDate::create([
                        'user_id' => $renter->id,
                        'amount_due' => $price->price,
                        'payment_due_date' => $this->payment_due_date,
                        'status' => 'not paid',
                    ]);
                }
            }
        }
        // Reset modal status after sending the bills
        $this->isSend = false;
        return redirect()->route('admin.occupants.index')->with('success', 'Bills for this month successfully sent to renters.');
    }
    public function showReceipt($receipt,$due_id,$status)
    {
        $this->modal = true;
        $this->currentReceipt = $receipt;
        $this->due_id = $due_id;
        $this->currentStatus = $status;
    }
    public function close()
    {
        $this->modal = false;
        $this->currentReceipt = null;
        $this->due_id =null;
        $this->currentStatus =null;
        $this->reset(['currentReceipt','due_id','currentStatus']); // Reset specific property
    }

    public function render()
    {
            // Start the query with the Apartment model and join the necessary relationships
            $query = Appartment::with(['categories', 'buildings', 'users'])
            ->select(
                'users.name as renters_name',
                'users.role',
                'users.id as user_id',
                'users.phone_number',
                'users.email',
                'apartment.id',
                'categories.name as categ_name',
                'apartment.room_number',
                'categories.price',
                'buildings.name as building_name',
                DB::raw('DATE_FORMAT(apartment.created_at, "%b-%d-%Y") as date')
            )
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->join('buildings','buildings.id', '=', 'apartment.building_id')
            ->Join('users', 'users.id', '=', 'apartment.renter_id')
            ->where('users.role','renter')
            ->orderBy($this->sortColumn, $this->sortDirection);
        // Filter based on the search
        if (!empty($this->search)) {
            $query->where(function($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('users.phone_number', 'like', '%' . $this->search . '%')
                ->orWhere('users.email', 'like', '%' . $this->search . '%')
                ->orWhere('categories.name', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.room_number', 'like', '%' . $this->search . '%')
                ->orWhere('buildings.name', 'like', '%' . $this->search . '%');
            });
        }
    
        // Execute the query and return the results
        $apartments = $query->paginate($this->perPage);
        $due_dates = DueDate::whereIn('user_id', $apartments->pluck('user_id'))->get()->keyBy('user_id');
        return view('livewire.admin.occupants-table', [
            'apartment' => $apartments, // Make sure this matches in the view
            'categories' => Category::all(),
            'due_dates' => $due_dates, // Ensure this is fetched correctly
            'buildings' => Building::all()
        ]);
    }
    
}
