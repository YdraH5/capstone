<?php

namespace App\Livewire;
use App\Models\Category;
use Livewire\Component;

class ApartmentEdit extends Component
{
    public function render(){
        return view('livewire.apartment-edit')
            ->with([
            'categories' => Category::all()
              ]);
   }
}
