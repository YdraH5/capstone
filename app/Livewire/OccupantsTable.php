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
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendReminder;


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
    public $open = false;
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
    public function out($apartment_id){
        $apartment = Appartment::where('id',$apartment_id)->first();

        Appartment::where('id', $apartment_id)
            ->update([
                'status' => 'Available',
                'renter_id' => null // Clear the renter_id since the reservation is rejected
            ]);
        User::where('id',$apartment->renter_id)
        ->update(['role'=>'departed']);
        return redirect()->route('admin.occupants.index')->with('success', 'Renter removed to the apartment successfully');

    }
    public function send()
    {
        $this->validate([
            'payment_due_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    // Extract the month and year from the provided date
                    $dueMonth = \Carbon\Carbon::parse($value)->month;
                    $dueYear = \Carbon\Carbon::parse($value)->year;
    
                    // Check if a bill has already been sent for this month and year
                    $existingDueDate = DueDate::whereMonth('payment_due_date', $dueMonth)
                        ->whereYear('payment_due_date', $dueYear)
                        ->exists();
    
                    if ($existingDueDate) {
                        $fail('Bills for this month and year have already been sent.');
                    }
                },
            ],
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
    public function sendReminderEmail($user_id,$daysOverdue)
    {
        $user = User::find($user_id);
        
        // Check if user exists
        if (!$user) {
            session()->flash('error', 'User not found.');
            return;
        }

        // Retrieve all unpaid dues
        $unpaidDues = DueDate::where('user_id', $user_id)
            ->where('status', 'not paid')
            ->where(function ($query) {
                $query->where('payment_due_date', '<', now())
                      ->orWhere('payment_due_date', '=', now()->format('Y-m-d'));
            })->get();

        // Check if there are unpaid dues
        if ($unpaidDues->isEmpty()) {
            session()->flash('error', 'No unpaid dues found.');
            return;
        }
        // Prepare dues data
        $duesData = $unpaidDues->map(function($due) {

            return [
                'amount' => number_format($due->amount_due, 2),
                'date' => Carbon::parse($due->payment_due_date)->format('F j, Y'),

            ];
        });

         // Prepare email data
         $emailData = [
            'name' => $user->name,
            'dues' => $duesData,
            'daysOverdue' => $daysOverdue,
        ];

        // Send the email
        Mail::to($user->email)->send(new SendReminder($emailData));
    
        return redirect()->route('admin.occupants.index')->with('success', 'Reminder email sent successfully to ' . $user->name);

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
                'apartment.id as apartment_id',
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
        
        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.occupants-table', [
                'apartment' => $apartments, // Make sure this matches in the view
                'categories' => Category::all(),
                'due_dates' => $due_dates, // Ensure this is fetched correctly
                'buildings' => Building::all()
            ]);
        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.occupants-table', [
                'apartment' => $apartments, // Make sure this matches in the view
                'categories' => Category::all(),
                'due_dates' => $due_dates, // Ensure this is fetched correctly
                'buildings' => Building::all()
            ]);
        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
    
}
