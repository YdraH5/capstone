<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BUilding;
use Livewire\Attributes\Validate; 
use Livewire\WithPagination;

class BuildingTable extends Component
{
    use WithPagination;

    #[Validate('required')] 
    public $name = '';
 
    #[Validate('required|numeric')] 
    public $units = '';

    #[Validate('required')] 
    public $parking_space = '';
    public $id; // to save the id that the user want to edit
    public $isEditing = false;// to only run the form when the user clicked the edit icon
    public $isDeleting =false;
    public $editBuilding;
    public $deleteId;

    // function to collect the current data that user wanted to update
    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;
        $this->editBuilding = Building::find($id);
        $this->name = $this->editBuilding->name;
        $this->units = $this->editBuilding->units;
        $this->parking_space = $this->editBuilding->parking_space;

    }
    // function to update the data that was selected 
    public function update(){
        $this->validate();
         // Find the apartment record by its ID
        $building = Building::find($this->id);

        // Update the apartment record with the new data
        $building->update([
            'name' => $this->name,
            'units' => $this->units,
            // 'price' => $this->price,
            'parking_space' => $this->parking_space,
        ]);
        $this->isEditing = false;
        $this->reset();
        // Reset the component state
        session()->flash('success', 'Building updated successfully.');
    }
    // function to get the id of the data that user wanted to delete
    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }

    // function to delete the data from database
    public function deleted(){
        $delete = Building::find($this->deleteId)->delete();
        if($delete){
            session()->flash('success', 'Building deleted successfully.');
            $this->reset();
        }
        $this->isDeleting = false;
    }
    public function render()
    {
        return view('livewire.admin.building-table',[
            'buildings' => Building::all()]);
    }
}
