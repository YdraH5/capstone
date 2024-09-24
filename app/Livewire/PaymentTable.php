<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Category;
use App\Models\User;
use App\Models\DueDate;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class PaymentTable extends Component
{
    use WithPagination;
    public $search;
    public $page = 'validation';
    public $sortDirection="ASC";
    public $sortColumn ="user_name";
    public $perPage = 10;
    public $currentReceipt;
    public $payment_id;
    public $currentStatus;
    public $modal = false;
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
    public function showReceipt($receipt,$payment_id,$status)
    {
        $this->modal = true;
        $this->currentReceipt = $receipt;
        $this->payment_id = $payment_id;
        $this->currentStatus = $status;
    }
    public function close()
    {
        $this->modal = false;
        $this->currentReceipt = null;
        $this->payment_id =null;
        $this->currentStatus =null;
        $this->reset(['currentReceipt','payment_id','currentStatus']); // Reset specific property
    }
    public function approve(){

        // Retrieve the specific payment record    
    
        // Update the status of the payment record
        Payment::where('id' ,$this->payment_id)
        ->update(['status'=>'Paid']);
        
        DueDate::where('payment_id', $this->payment_id)
        ->update(['status'=>'Paid']);
        // Retrieve user information
        session()->flash('success', 'Payment Accepted'); // Set the success flash message
        }
    public function send()
    {
        // Get all apartments where the renter_id is set
        $apartments = DB::table('apartment')
            ->whereNotNull('renter_id')
            ->get();
    
        foreach ($apartments as $apartment) {
            $price = Category::find($apartment->category_id);
            // Get the renter associated with the apartment
            $renter = User::find($apartment->renter_id);
            
            if ($renter) {
                // Create a payment record for the renter
                Payment::create([
                    'user_id' => $renter->id,
                    'apartment_id' => $apartment->id,
                    'amount' => $price->price, // You might need to set this to the appropriate amount
                    'payment_method' => '', // You might want to adjust this depending on your requirements
                    'status' => 'unpaid',
                    'category'=>'Rent Fee',
                ]);
            }
        }
        session()->flash('success', 'BIlls for this month succesfully sent to renters.');

    }
    
    
    public function render()
    {
        // Start the query with the Payment model and join the necessary relationships
        $query = Payment::with(['user', 'apartment'])
            ->select(
                'users.name as user_name',
                'payments.id',
                'payments.category',
                'payments.amount',
                'payments.receipt',
                'payments.transaction_id',
                'payments.payment_method',
                'payments.status',
                'buildings.name as building_name',
                'apartment.room_number',
                DB::raw('DATE_FORMAT(apartment.created_at, "%b-%d-%Y") as date'),
            )
            ->leftJoin('users', 'users.id', '=', 'payments.user_id')
            ->leftJoin('apartment', 'apartment.id', '=', 'payments.apartment_id')
            ->leftjoin('buildings','buildings.id', '=', 'apartment.building_id')
            ->orderBy($this->sortColumn, $this->sortDirection);
    
        // Filter based on the search
        if (!empty($this->search)) {
            $query->where(function($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.category', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.transaction_id', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.payment_method', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.status', 'like', '%' . $this->search . '%')
                    ->orWhere('buildings.name', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.created_at', 'like', '%' . $this->search . '%')
                    ->orWhere('apartment.room_number', 'like', '%' . $this->search . '%');
            });
        }
    
        // Execute the query and return the results
        $payments = $query->paginate($this->perPage);
    
        return view('livewire.admin.payment-table', compact('payments'));
    }
    
    
}
