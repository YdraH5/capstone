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
        // Array to hold selected features
    public $features = [
        'pax' =>'',
        'livingRoom' => false,
        'cr' => false,
        'balcony' => false,
        'kitchen' => false,
        'aircon'=>false,
        'bed'=>false,
        'parking'=>false,
        'otherText' => '', // Text input for specifying other features
        'other' => false, // Checkbox for Other
        ];   
    public function save()
    {
        $this->validate([
            'name' => 'required|max:50|unique:categories,name',
            'price' => 'required|numeric',
        ]); 

        // Encode the features array as JSON
        $featuresJson = json_encode($this->features);

        Category::create([
            'name' => $this->name,
            'price' => $this->price,
            'description' => $featuresJson, // Store JSON-encoded features
        ]);
        
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
