<?php

namespace App\Livewire;
use Livewire\Attributes\Validate; 
use App\Models\Building;

use Livewire\Component;

class BuildingForm extends Component
{
    #[Validate('required')] 
    public $name = '';
 
    #[Validate('required')] 
    public $units = '';

    #[Validate('required')] 
    public $parking_space = '';

    public function save(){
        $this->validate([
            'name'=>'required',
            'units'=>'required',
            'parking_space'=>'required'
        ]);
        Building::create([
            'name'=>$this->name,
            'units'=>$this->units,
            'parking_space'=>$this->parking_space
        ]);
        return redirect()->route('admin.building.index')->with('success', 'Adding building success');

    }
    public function render()
    {
        return view('livewire.admin.building-form');
    }
}
