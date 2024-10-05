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
 
    #[Validate('required|min:10|max:200')] 
    public $description = '';

    #[Validate('required|numeric')] 
    public $price = '';
    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;

        $this->editCategory = Category::find($id);
        $this->name = $this->editCategory->name;
        $this->price = $this->editCategory->price;
        $this->description = $this->editCategory->description;
    }
    public function update(){
            $this->validate();
             // Find the apartment record by its ID
            $category = Category::find($this->id);
    
            // Update the apartment record with the new data
            $category->update([
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
            ]);
            
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
