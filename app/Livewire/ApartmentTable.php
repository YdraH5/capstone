<?php

namespace App\Livewire;
use Livewire\Attributes\Validate; 
use App\Models\Appartment;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ApartmentTable extends Component
{
    public $editApartment;// to save data that use is going to edit
    public $isEditing= false;// to only run the form when the user clicked the edit icon
    public $id; // to save the id that the user want to edit
    public $search = ""; // to set an empty string for search
    public $deleteId;

    #[Validate('required')] 
    public $category_id;
 
    #[Validate('required')] 
    public $building;
 
    #[Validate('required|numeric')] 
    public $price;

    #[Validate('required')] 
    public $status;

    #[Validate('required|numeric')] 
    public $room_number;

    public Appartment $selectedApartment;

    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;
        // to set the value of current data to the public variables
        $this->editApartment = Appartment::find($id);
        $this->category_id = $this->editApartment->category_id;
        $this->building = $this->editApartment->building;
        $this->price = $this->editApartment->price;
        $this->status = $this->editApartment->status;
        $this->room_number = $this->editApartment->room_number;
        $this->editApartment = Appartment::find($id);  
    }
    public function update(){
        $this->validate();
         // Find the apartment record by its ID
        $apartment = Appartment::find($this->id);

        // Update the apartment record with the new data
        $apartment->update([
            'category_id' => $this->category_id,
            'building' => $this->building,
            'price' => $this->price,
            'status' => $this->status,
            'room_number' => $this->room_number,
        ]);
        $this->reset();
        // Reset the component state
        session()->flash('success', 'Apartment updated successfully.');
    }
    public function delete($id){
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Appartment::find($this->deleteId)->delete();
        if($delete){
            session()->flash('success', 'Apartment deleted successfully.');
            $this->reset();
        }
    }
    public function render()
    {
        $categories = Category::all();
        $apartment = new Appartment();
        return view('livewire.admin.apartment.apartment-table', [
            'apartment' => $apartment->search($this->search),
            'categories' => $categories,
        ]);
    }
    
}
