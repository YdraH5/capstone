<?php

namespace App\Livewire;
use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Validate; 
class CategoryTable extends Component
{   
    public $deleteId;
    public $isEditing= false;// to only run the form when the user clicked the edit icon
    public $id; // to save the id that the user want to edit
    public $editCategory;// to save data that use is going to edit

    #[Validate('required|min:5|max:50')] 
    public $name = '';
 
    #[Validate('required|min:10|max:200')] 
    public $description = '';

    public function edit($id){
        $this->isEditing = true;
        $this->id = $id;

        $this->editCategory = Category::find($id);
        $this->name = $this->editCategory->name;
        $this->description = $this->editCategory->description;
    }
    public function update(){
            $this->validate();
             // Find the apartment record by its ID
            $category = Category::find($this->id);
    
            // Update the apartment record with the new data
            $category->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            $this->reset();
            // Reset the component state
            session()->flash('success', 'Category updated successfully.');
    }
    public function delete($id){
        $this->deleteId = $id;
    }
    public function deleted(){
        $delete = Category::find($this->deleteId)->delete();
        if($delete){
            session()->flash('success', 'Category deleted successfully.');
            $this->reset();
        }
    }
    public function render()
    {
        $categories = Category::cursorPaginate(10);
        return view('livewire.admin.category-table', [
            'categories' => $categories,
        ]);    }
}
