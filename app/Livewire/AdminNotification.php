<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
class AdminNotification extends Component
{
    public function render()
    {
        return view('livewire.admin-notification',['categories'=>Category::all()]);
    }
}
