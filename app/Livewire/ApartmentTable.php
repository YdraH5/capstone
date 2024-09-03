<?php

namespace App\Livewire;
use Livewire\Attributes\Validate; 
use App\Models\Appartment;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ApartmentTable extends Component
{
    use WithPagination;
    public $editApartment ;
    private $editPrice;
    public $isEditing= false;// to only run the form when the user clicked the edit icon
    public $id; // to save the id that the user want to edit
    public $search = ""; // to set an empty string for search
    public $deleteId;

    #[Validate('required')] 
    public $category_id;
 
    #[Validate('required')] 
    public $building_id;
 

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
        $this->building_id = $this->editApartment->building_id;
        $this->status = $this->editApartment->status;
        $this->room_number = $this->editApartment->room_number;
         
    }
   
    public function update(){
        $this->validate();
         // Find the apartment record by its ID
        $apartment = Appartment::find($this->id);

        // Update the apartment record with the new data
        $apartment->update([
            'category_id' => $this->category_id,
            'building_id' => $this->building_id,
            // 'price' => $this->price,
            'status' => $this->status,
            'room_number' => $this->room_number,
        ]);

        $this->reset();
        // Reset the component state
        session()->flash('success', 'Apartment updated successfully.');
    }
    public function close(){
        $this->isEditing = false;
        $this->reset(['category_id','building_id','status','room_number','id','editApartment']);
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
        $apartments = Appartment::query()
            ->when($this->search, function ($query, $keyword) {
                $query->where('users.name', 'like', '%' . $keyword . '%')
                    ->orWhere('categories.name', 'like', '%' . $keyword . '%')
                    ->orWhere('apartment.status', 'like', '%' . $keyword . '%')
                    ->orWhere('apartment.room_number', 'like', '%' . $keyword . '%')
                    ->orWhere('apartment.building_id', 'like', '%' . $keyword . '%')
                    ->orWhere('categories.price', 'like', '%' . $keyword . '%');
            })
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->join('buildings','buildings.id', '=', 'apartment.building_id')
            ->leftJoin('users', 'users.id', '=', 'apartment.renter_id')
            ->select(
                'buildings.name as building_name',
                'categories.id as categ_id',
                'categories.name as categ_name',
                'users.name as renters_name',
                'apartment.id',
                'apartment.room_number',
                'categories.price',
                'apartment.status',
                'apartment.building_id'
            )
            ->Paginate(10);

        return view('livewire.admin.apartment-table', [
            'apartment' => $apartments,
            'categories' => $categories,
        ]);
    }
}
