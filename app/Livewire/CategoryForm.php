<?php

namespace App\Livewire;
use App\Models\Category;
use Livewire\Attributes\Validate; 
use Livewire\Component;

class CategoryForm extends Component
{
    #[Validate('required|min:5|max:50')] 
    public $name = '';
 
    #[Validate('required|min:10|max:200')] 
    public $description = '';

    #[Validate('require')] 
    public $id;
    public function saveCategory()
    {
        $this->validate(); 
 
        Category::create(
            $this->only(['name', 'description'])
        );
        return redirect()->route('admin.categories.index')->with('success','Adding category success');
    }

    public function render()
    {
        return view('livewire.category.category-form');
    }
}
