<?php

namespace App\Livewire;
use App\Models\User;
use Livewire\Component;

class UserTable extends Component
{
    public $search;
    public function render()
    {
        $report = new User();
        return view('livewire.admin.user.user-table', [
            'users' => $report->search($this->search),
        ]);
    }
}
