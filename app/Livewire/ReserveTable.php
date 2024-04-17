<?php

namespace App\Livewire;
use App\Models\Reservation;
use Livewire\Component;

class ReserveTable extends Component
{
    public $search;
    public function render()
    {
        $reservations = new Reservation();
        return view('livewire.admin.reserve.reserve-table', [
            'reservations' => $reservations->search($this->search),
        ]);
    }
}
