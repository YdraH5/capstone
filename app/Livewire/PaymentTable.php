<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentTable extends Component
{
    public $search;
    public $page = 'validation';
    public function approve(){

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
                'apartment.building_id',
                'buildings.name AS building_name',
                'apartment.room_number',
                DB::raw('DATE_FORMAT(apartment.created_at, "%b-%d-%Y") as date'),
            )
            ->leftJoin('users', 'users.id', '=', 'payments.user_id')
            ->leftJoin('apartment', 'apartment.id', '=', 'payments.apartment_id')
            ->leftJoin('buildings', 'buildings.id', '=', 'apartment.building_id')
            ->orderBy('payments.created_at', 'asc'); // Order by payments.created_at
    
        // Filter based on the search
        if (!empty($this->search)) {
            $query->where(function($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.category', 'like', '%' . $this->search . '%')
                    ->orWhere('buildings.name', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.transaction_id', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.payment_method', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.status', 'like', '%' . $this->search . '%')
                    ->orWhere('payments.created_at', 'like', '%' . $this->search . '%')
                    ->orWhere('apartment.room_number', 'like', '%' . $this->search . '%');
            });
        }
    
        // Execute the query and return the results
        $payments = $query->paginate(10);
    
        return view('livewire.admin.payment-table', compact('payments'));
    }
    
    
}
