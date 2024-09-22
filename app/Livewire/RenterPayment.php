<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use Carbon\Carbon;
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
        switch($this->page){
            case 'history':
            $payments = Payment::where('user_id',$user->id)
                ->where('status','paid')->get();
                break;
            case 'to pay':
            $payments = Payment::where('user_id', $user->id)
                ->where('created_at', '<=', $currentDate)
                ->where('status','unpaid')
                ->get();
                break;
        }
        return view('livewire.renter.renter-payment',compact('payments'));
    }
}
