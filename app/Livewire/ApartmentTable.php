<?php

namespace App\Livewire;
use App\Models\Appartment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ApartmentTable extends Component
{
    public $search = "";
    public function render()
{
    $apartment = new Appartment();
    return view('livewire.apartment-table', [
        'apartment' => $apartment->search($this->search),
    ]);
}
    
}
