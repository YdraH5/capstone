<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Nearby;
class NearbyForm extends Component
{
    use WithFileUploads;

    public $name, $description, $distance, $image;

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'distance' => 'required|numeric|min:0',
            'image' => 'required|image|', // Image validation rules
        ]);
        $imagePath = $this->image->store('uploads/nearby/', 'public');
        
        Nearby::create([
            'name' => $this->name,
            'description' => $this->description,
            'distance' => $this->distance,
            'image_url' => $imagePath,
        ]);
        return redirect()->route('admin.nearby-establishment.index')->with('success', 'Uploading Nearby Establishment Success');

    }
    public function render()
    {
        return view('livewire.admin.nearby-form');
    }
}
