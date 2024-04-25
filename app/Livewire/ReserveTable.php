<?php

namespace App\Livewire;
use App\Models\Reservation;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
class ReserveTable extends Component
{
    public $search;
    // public function render()
    // {
    //     $reservations = new Reservation();
    //     return view('livewire.admin.reserve.reserve-table', [
    //         'reservations' => $reservations->search($this->search),
    //     ]);
    // }
    public function render()
    {
        $query = DB::table('users')
            ->join('reservations', 'users.id', '=', 'reservations.user_id')
            ->join('apartment', 'apartment.id', '=', 'reservations.apartment_id')
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->select(
                'apartment.id as apartment_id',
                'users.id as user_id',
                'users.name as user_name',
                'users.email',
                'categories.name as categ_name',
                'apartment.room_number',
                'apartment.building',
                DB::raw('DATE_FORMAT(reservations.check_in, "%b-%d-%Y") as check_in_date'),
                DB::raw('DATE_FORMAT(reservations.check_out, "%b-%d-%Y") as check_out_date'),
                'reservations.total_price',
                'reservations.payment_status',
                'apartment.building'
            )
            ->orderBy('reservations.created_at');

        // Filter based on the search search
        if (!empty($this->search)) {
            $query->where('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('categories.name', 'like', '%' . $this->search . '%')
                ->orWhere('users.email', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.status', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.room_number', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.building', 'like', '%' . $this->search . '%')
                ->orWhere('reservations.check_in', 'like', '%' . $this->search . '%')
                ->orWhere('reservations.check_out', 'like', '%' . $this->search . '%')
                ->orWhere('reservations.payment_status', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.price', 'like', '%' . $this->search . '%');
        }

        $reservations = $query->paginate(10);

        return view('livewire.admin.reserve-table', compact('reservations'));
    }
}
