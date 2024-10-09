<?php

namespace App\Livewire;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Validate; 
use Livewire\WithPagination;

class CategoryTable extends Component
{   
    use WithPagination;
    public $deleteId;
    public $isEditing= false;// to only run the form when the user clicked the edit icon
    public $id; // to save the id that the user want to edit
    public $editCategory;// to save data that use is going to edit
    public $isDeleting = false;
    #[Validate('required|min:5|max:50')] 
    public $name = '';
 
    public $features = [
        'pax'=>'',
        'cr' => false,
        'livingRoom' => false,
        'kitchen' => false,
        'balcony' => false,
        'aircon' => false,
        'bed' => false,
        'parking' => false,
        'otherText' => '',
    ];
    #[Validate('required|numeric')] 
    public $price = '';
    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;

        $this->editCategory = Category::find($id);
        $this->name = $this->editCategory->name;
        $this->price = $this->editCategory->price;
        $this->features = json_decode($this->editCategory->description, true);
         // Ensure defaults if decoding fails
         if (json_last_error() !== JSON_ERROR_NONE) {
            $this->features = [
                'pax'=> '',
                'cr' => false,
                'livingRoom' => false,
                'kitchen' => false,
                'balcony' => false,
                'aircon' => false,
                'bed' => false,
                'parking' => false,
                'otherText' => '',
            ];
        }

    }
    public function update()
    {
        $this->validate([
            'name' => 'required|max:50|unique:categories,name,' . $this->id,
            'price' => 'required|numeric',
        ]);
    
        // Encode features back to JSON
        $descriptionJson = json_encode($this->features);
    
        $category = Category::find($this->id);
        if ($category) {
            $category->update([
                'name' => $this->name,
                'price' => $this->price,
                'description' => $descriptionJson, // Store JSON-encoded features
            ]);
        }
        
        $this->reset();
            // Reset the component state
            session()->flash('success', 'Category updated successfully.');
    }
    public function delete($id){
        $this->isDeleting = true;
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Category::find($this->deleteId)->delete();
        if($delete){
            session()->flash('success', 'Category deleted successfully.');
            $this->reset();
        }
        $this->isDeleting=false;
    }
    public function render()
    {
        $categories = Category::cursorPaginate(10);
        return view('livewire.owner.category-table', [
            'categories' => $categories,
        ]);    }
}
