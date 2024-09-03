<?php
 
namespace App\Livewire;
 
use Livewire\Attributes\Validate; 
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Appartment;
use App\Models\Category;
use App\Models\Building;
use Illuminate\Support\Facades\DB;

use LivewireUI\Modal\ModalComponent;
class ApartmentForm extends Component
{
    #[Validate('required')] 
    public $category_id = '';
 
    #[Validate('required')] 
    public $building_id = '';

    #[Validate('required')] 
    public $status = '';

    #[Validate('required|numeric')] 
    public $room_number = '';
    
    public function save()
    {
        // Fetch the maximum units allowed for the selected building
        $maxUnits = DB::table('buildings')
        ->where('id', $this->building_id)
        ->value('units'); // Assuming the column name is 'max_units'

        // Count the current number of apartments for the selected building
        $currentCount = DB::table('apartment')
            ->where('building_id', $this->building_id)
            ->count();
       
        // Add validation with custom rule for max units check
        $this->validate([
            'category_id' => 'required',
            'status' => 'required',
            'room_number' => [
                'required',
                'numeric',
                Rule::unique('apartment')->where(function ($query) {
                    return $query->where('building_id', $this->building_id)
                        ->where('room_number', $this->room_number);
                }),
            ],
            // Custom rule to check if the apartment count exceeds the max units
            'building_id' => [
                'required',
                function ($attribute, $value, $fail) use ($currentCount, $maxUnits) {
                    if ($currentCount >= $maxUnits) {
                        $fail("The maximum number of units ($maxUnits) for this building has been reached.");
                    }
                },
            ],
        ]);
        Appartment::create([
            'category_id' => $this->category_id,
            'building_id' => $this->building_id,
            'status' => $this->status,
            'room_number' => $this->room_number,
        ]);
    
        return redirect()->route('admin.apartment.index')->with('success', 'Adding apartment room success');
    }
    public function render(){
        return view('livewire.admin.apartment-form')
            ->with([
            'categories' => Category::all(),
            'buildings' => Building::all()
              ]);
   }
}
      
