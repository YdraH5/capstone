<?php
 
namespace App\Livewire;
 
use Livewire\Attributes\Validate; 
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Appartment;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;
class ApartmentForm extends Component
{
    #[Validate('required')] 
    public $category_id = '';
 
    #[Validate('required')] 
    public $building = '';

    #[Validate('required')] 
    public $status = '';

    #[Validate('required|numeric')] 
    public $room_number = '';
    
    public function save()
    {
        $this->validate([
            'category_id' => 'required',
            'building' => 'required',
            'status' => 'required',
            'room_number' => [
                'required',
                'numeric',
                Rule::unique('apartment')->where(function ($query) {
                    return $query->where('building', $this->building)
                        ->where('room_number', $this->room_number);
                }),
    
            ],
        ]);
    
        Appartment::create([
            'category_id' => $this->category_id,
            'building' => $this->building,
            'status' => $this->status,
            'room_number' => $this->room_number,
        ]);
    
        return redirect()->route('admin.apartment.index')->with('success', 'Adding apartment room success');
    }
    public function render(){
        return view('livewire.admin.apartment-form')
            ->with([
            'categories' => Category::all()
              ]);
   }
}
      
