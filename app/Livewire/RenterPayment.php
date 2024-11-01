<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class RenterPayment extends Component
{

    public $paymentId;
    public $dueDate;
    public $page ='history';
   
    public function render()
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->day(25);

        // Fetch payments along with due dates using DB
        $payments = DB::table('payments')
        ->join('due_dates', 'payments.id', '=', 'due_dates.payment_id') // Assuming 'payments' is the name of the payments table
        ->select('payments.category', 'payments.payment_method', 'payments.status', 'payments.amount', 'payments.created_at', 'due_dates.payment_due_date')
        ->where('payments.user_id', $user->id)
        ->get();
        return view('livewire.renter.renter-payment', compact('payments'));
    }
    
}
