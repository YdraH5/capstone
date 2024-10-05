<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Payment;
use App\Models\DueDate;
use App\Models\Category;
use App\Models\Appartment;
use Livewire\Attributes\Validate; 

class PaymentForm extends Component
{ 
    public $username;
    public $amount;
    public $dueDates = [];

    public $apartment_id='';
    public $pament_method='';
    public $duedate_id = null;
    public $category='';
    public $status='';

    #[Validate('required')]
    public $users;
    public $selectedUserId;
    public $user_id;    
    public $open = false;
    public function mount(){
        if($this->open){
        $category_id = Appartment::find($this->apartment_id)->first();
        $this->amount =  Category::find($category_id->price)->first();
        }
    }
    public function searchUser()
    {
        // Perform the search for the username
        $this->users = User::where('role', 'renter')
            ->where('name', 'like', '%' . $this->username . '%')
            ->get();

        // If no users are found, set an error
        if ($this->users->isEmpty()) {
            $this->addError('username', 'No user found with this name.'); // Adds an error message
        }
    }

    public function selectUser($userId, $name)
{
    $this->username = $name;
    $this->selectedUserId = $userId;
    $this->duedate_id = null; // Reset here
    $this->user_id = $userId; // Assign user_id for validation
    $this->users = [];
 
    // Fetch user's apartment and related due dates
    $apartment = Appartment::where('renter_id', $userId)->first();
    $this->dueDates = DueDate::where('user_id', $userId)->where('status', 'not paid')->get();
 
    if ($apartment) {
        $category = Category::where('id', $apartment->category_id)->first();
        if ($category) {
            $this->amount = $category->price;
            $this->category = $category->name;
            $this->apartment_id = $apartment->id;
        } else {
            $this->amount = null;
            $this->apartment_id = null;
        }
    } else {
        $this->amount = null;
        $this->apartment_id = null;
    }

    // If there are no unpaid due dates, set dueDates to null
    if ($this->dueDates->isEmpty()) {
        $this->dueDates = null; // Signal payments are up to date
    }
}


    
    
    public function save()
{
    $this->validate([
        'apartment_id' => 'required',
        'selectedUserId' => 'required',
        'amount' => 'required|numeric',
        'duedate_id'=>'required',
    ]); 

    // Remove dd($this->apartment_id);

    $payment = Payment::create([
        'apartment_id' => $this->apartment_id,
        'user_id' => $this->selectedUserId, // Use selectedUserId here
        'status' => 'paid',
        'payment_method' => 'cash',
        'category' => 'Lease',
        'amount' => $this->amount,
    ]);
    $due_pay = DueDate::where('id', $this->duedate_id)
    ->update([ // Use update() here, not updates()
        'status' => 'paid',
        'payment_id' => $payment->id // Correctly access the ID of the newly created payment
    ]);

    // Redirect based on role
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.payments.index')->with('success', 'Adding payment success');
    } elseif (auth()->user()->role === 'owner') {
        return redirect()->route('owner.payments.index')->with('success', 'Adding payment success');
    } else {
        abort(403, 'Unauthorized action.');
    }
}

    public function render()
    {
        $apartments = Appartment::all();
        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.payment-form',compact('apartments'));

        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.payment-form',compact('apartments'));

        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
}
