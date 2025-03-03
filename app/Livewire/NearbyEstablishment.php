<?php

namespace App\Livewire;

use App\Models\Nearby;  // Make sure to import the Nearby model
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class NearbyEstablishment extends Component
{
    use WithPagination;
    use WithFileUploads; // Include the WithFileUploads trait

    public $search,$id,$deleteId,$name,$description,$distance,$image_url;
    public $isDeleting = false;
    public $sortDirection = "ASC";
    public $sortColumn = "name";
    public $perPage = 10;

    public $isEditing = false;
    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;
        // to set the value of current data to the public variables
        $nearby = Nearby::find($id);
          // Assign the announcement's data to the component's public properties
        $this->name = $nearby->name;
        $this->description = $nearby->description;
        $this->distance = $nearby->distance;
        $this->image_url = $nearby->image_url;
    }
   
    public function update()
    {
        // Validate inputs
        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'distance' => 'required|numeric',
            'image_url' => ($this->image_url) 
                ? 'required|image|max:2048' 
                : 'nullable',
        ]);
    
        // Find the existing record
        $nearby = Nearby::find($this->id);
    
        $imagePath = $this->image_url->store('uploads/nearby/', 'public');

        
    
        // Update the other fields
        $nearby->update([
            'name' => $this->name,
            'description' => $this->description,
            'distance' => $this->distance,
            'image_url'=> $imagePath,
        ]);
    
        // Reset the form and state
        $this->isEditing = false;
        $this->reset();
    
        // Flash success message
        session()->flash('success', 'Nearby establishment updated successfully.');
    }
    

    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Nearby::find($this->deleteId)->delete();
        if($delete){
            session()->flash('success', 'Nearby Establishment deleted successfully in the system.');
            $this->reset();
        }
        $this->isDeleting = false;
    }
    public function doSort($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = ($this->sortDirection === 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search input is updated
    }

    public function render()
    {
        $nearbyEstablishments = Nearby::select(
            'id',
            'name',
            'description',
            'distance',
            'image_url',
            DB::raw('DATE_FORMAT(created_at, "%b-%d-%Y") as date')
        )->orderBy($this->sortColumn, $this->sortDirection);

        if ($this->search) {
            $nearbyEstablishments->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('distance', 'like', '%' . $this->search . '%')
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
        }

        $nearbyEstablishments = $nearbyEstablishments->paginate($this->perPage);

        // Conditionally render the correct view based on user role
            return view('livewire.admin.nearby-establishment', [
                'nearbyEstablishments' => $nearbyEstablishments
            ]);
        
    }
}
