<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationSuccess;
use Illuminate\Support\Facades\Queue;

class ReserveTable extends Component
{
    public $modal = false;
    public $search = '';
    public $currentReceipt;
    public $id;
    public $currentStatus;
    protected $listeners = ['showReceipt'];

    public function showReceipt($receipt,$status,$id)
    {
        $this->modal = true;
        $this->currentReceipt = $receipt;
        $this->id = $id;
        $this->currentStatus = $status;
    }
    public function close()
    {
        $this->modal = false;
        $this->currentStatus = null;
        $this->currentReceipt = null;
        $this->id =null;
        $this->reset(['currentReceipt','currentStatus','id']); // Reset specific property
    }

    public function approve($id)
    {
        // Use a transaction to group database updates for consistency and speed
        DB::transaction(function () use ($id) {
            // Retrieve the specific payment record and related user data in one go
            $payment = Payment::where('reservation_id', $id)
                ->with('user') // Assuming a relationship is defined in the Payment model
                ->first();
    
            if (!$payment) {
                session()->flash('error', 'Payment not found');
                return;
            }
    
            // Update the status of the payment record
            $payment->update(['status' => 'paid']);
    
            // Update user role and apartment status in one transaction for efficiency
            DB::table('users')
                ->where('id', $payment->user_id)
                ->update(['role' => 'reserve']);
    
            DB::table('apartment')
                ->where('id', $payment->apartment_id)
                ->where('status', 'Available')
                ->update([
                    'status' => 'Reserved',
                    'renter_id' => $payment->user_id
                ]);
    
            // Set the success flash message
            session()->flash('success', 'The reservation has been approved');
    
            // Prepare email data
            $user = $payment->user;
            $dataemail = [
                'name' => $user->name,
                'payment' => $payment->amount,
            ];
    
            // Queue the email to send it asynchronously
            Mail::to($user->email)->queue(new ReservationSuccess($dataemail));
        });
    }

    public function render()
    {
        // Base query with necessary joins
        $query = DB::table('users')
            ->join('reservations', 'users.id', '=', 'reservations.user_id')
            ->join('apartment', 'apartment.id', '=', 'reservations.apartment_id')
            ->join('buildings','buildings.id', '=', 'apartment.building_id')
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->join('payments', 'reservations.id', '=', 'payments.reservation_id')
            ->select(
                'apartment.id as apartment_id',
                'users.id as user_id',
                'users.name as user_name',
                'users.email',
                'categories.name as categ_name',
                'apartment.room_number',
                'buildings.name as building_name',
                DB::raw('DATE_FORMAT(reservations.check_in, "%b-%d-%Y") as check_in_date'),
                DB::raw('DATE_FORMAT(reservations.check_out, "%b-%d-%Y") as check_out_date'),
                'reservations.id as reservation_id',
                'reservations.total_price',
                'payments.receipt',
                'payments.status'
            )
            ->orderBy('reservations.created_at');

        // Search fields
        $searchFields = [
            'users.name',
            'categories.name',
            'users.email',
            'apartment.status',
            'apartment.room_number',
            'apartment.building',
            'reservations.check_in',
            'reservations.check_out',
            'payments.status',
            'reservations.total_price'
        ];

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($query) use ($searchFields) {
                foreach ($searchFields as $field) {
                    $query->orWhere($field, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Paginate the results
        $reservations = $query->paginate(10);

        // Return view with the reservations data
        return view('livewire.admin.reserve-table', compact('reservations'));
    }
}
