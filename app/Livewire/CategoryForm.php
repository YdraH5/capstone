<?php

namespace App\Livewire;
use App\Models\Category;
use Livewire\Attributes\Validate; 
use Livewire\Component;

class CategoryForm extends Component
{
    #[Validate('required|min:5|max:50')] 
    public $name = '';
 
    #[Validate('required|numeric')]
    public $price = '';

    #[Validate('required|min:10|max:200')] 
    public $description = '';

    #[Validate('require')] 
    public $id;
    public function save()
    {
        $this->validate([
            'name' => 'required|max:50|unique:categories,name',
            'price' => 'required|numeric',
            'description' => 'required|max:190'
        ]); 
 
        Category::create(
            $this->only(['name', 'price','description'])
        );
        $this->reset();
        return redirect()->route('owner.categories.index')->with('success','Adding category success');
    }
    public function update(){
        dd($this->id);
    }
    public function render()
    {
        return view('livewire.owner.category-form');
    }
}
