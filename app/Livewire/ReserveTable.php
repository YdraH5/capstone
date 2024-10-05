<?php

namespace App\Livewire;

use App\Models\Payment;
use App\Models\Appartment;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationSuccess;
use Livewire\WithPagination;

class ReserveTable extends Component
{
    use WithPagination;
    public $modal = false;
    public $search = '';
    public $currentReceipt;
    public $id;
    public $categ_id;
    public $currentStatus;
    protected $listeners = ['showReceipt'];
    public $sortDirection="ASC";
    public $sortColumn ="user_name";
    public $perPage = 10;

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

    public function showReceipt($receipt,$categ_id,$status,$id)
    {
        $this->modal = true;
        $this->currentReceipt = $receipt;
        $this->id = $id;
        $this->categ_id = $categ_id;
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
    // Count available apartments
    $available = DB::table('apartment')
        ->where('category_id', $this->categ_id)
        ->whereIn('status', ['Available', 'Under Review'])  // Use whereIn for multiple statuses
        ->count();
    if($available > 0)
    {
    // Retrieve the specific payment record
    $payment = Payment::where('reservation_id', $id)->first();


    // Update the status of the payment record
    $payment->update(['status' => 'paid']);

    // Update user role
    User::where('id', $payment->user_id)
        ->update(['role' => 'reserve']);

     // Update apartment status
     Appartment::where('id', $payment->apartment_id)
        ->update(['status' => 'Reserved',
                'renter_id' => $payment->user_id]);

    // Retrieve user information
    $user = DB::table('users')->where('id', $payment->user_id)->first();
    session()->flash('success', 'The reservation has been approved'); // Set the success flash message

    // Prepare email data
    $dataemail = [
        'name' => $user->name,
        'payment' => $payment->amount,
    ];
    // Send email
    Mail::to($user->email)->send(new ReservationSuccess($dataemail));
    $this->modal = true;
    }
    }
    public function reject($id)
    {
        // Retrieve the specific payment record
        $payment = Payment::where('reservation_id', $id)->first();
    
        if ($payment) {
            // Update the status of the payment record to 'rejected'
            $payment->update(['status' => 'Rejected']);
    
            // Update the apartment status to 'Available' and remove the renter_id
            Appartment::where('id', $payment->apartment_id)
                ->update([
                    'status' => 'Available',
                    'renter_id' => null // Clear the renter_id since the reservation is rejected
                ]);
            
            // Retrieve user information
            $user = DB::table('users')->where('id', $payment->user_id)->first();
    
            // Set the flash message to indicate rejection
            session()->flash('error', 'The reservation has been rejected');
    
            // Prepare email data
            $dataemail = [
                'name' => $user->name,
                'payment' => $payment->amount,
            ];
    
            // Send email notification to user about the rejection
    
            $this->modal = true;
        } else {
            session()->flash('error', 'Payment record not found.');
        }
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
                'categories.id as categ_id',
                'apartment.room_number',
                'buildings.name as building_name',
                DB::raw('DATE_FORMAT(reservations.check_in, "%b-%d-%Y") as check_in_date'),
                'reservations.rental_period',
                'reservations.id as reservation_id',
                'reservations.total_price',
                'reservations.status as reservation_status',
                'payments.receipt',
                'payments.payment_method',
                'payments.status'
            )
            ->orderBy($this->sortColumn, $this->sortDirection);

        // Search fields
        $searchFields = [
            'users.name',
            'categories.name',
            'users.email',
            'apartment.status',
            'apartment.room_number',
            'buildings.name',
            'reservations.check_in',
            'reservations.rental_period',
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
        $reservations = $query->paginate($this->perPage);
                 // Conditionally render the correct view based on user role
                 if (auth()->user()->role === 'admin') {
                    return view('livewire.admin.reserve-table', compact('reservations'));

                } elseif (auth()->user()->role === 'owner') {
                    return view('livewire.owner.reserve-table', compact('reservations'));

                } else {
                    // Handle if user doesn't have the right role
                    abort(403, 'Unauthorized action.');
                }
    }
}
