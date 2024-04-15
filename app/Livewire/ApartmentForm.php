<?php
 
namespace App\Livewire;
 
use Livewire\Attributes\Validate; 
use Livewire\Component;
use App\Models\Appartment;
use App\Models\Category;
use LivewireUI\Modal\ModalComponent;
class ApartmentForm extends Component
{
    #[Validate('required')] 
    public $category_id = '';
 
    #[Validate('required')] 
    public $building = '';
 
    #[Validate('required|numeric')] 
    public $price = '';

    #[Validate('required')] 
    public $status = '';

    #[Validate('required|numeric')] 
    public $room_number = '';
    
    public function save()
    {
        $this->validate(); 
 
        Appartment::create(
            $this->only(['category_id', 'building','price','status','room_number'])
        );
        return redirect()->route('admin.apartment.index')->with('success','Adding apartment room success');
    }
    public function render(){
        return view('livewire.apartment.apartment-form')
            ->with([
            'categories' => Category::all()
              ]);
   }
}
      
