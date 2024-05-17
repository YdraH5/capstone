<?php

namespace App\Livewire;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
class UserTable extends Component
{
    public $search;
    public function render()
    {
        $users = User::query()->select(
            'name',
            'email',
            'role',
            DB::raw('DATE_FORMAT(created_at, "%b-%d-%Y") as date')
        );
        if ($this->search) {
            $users->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('role', 'like', '%' . $this->search . '%')
                  ->orWhere('created_at', 'like', '%' . $this->search . '%');
        }
        return view('livewire.admin.user-table', [
            'users' => $users->paginate(10),
        ]);
    }
}
