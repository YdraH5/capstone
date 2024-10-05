<?php

namespace App\Livewire;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;
    public $search;
    public $sortDirection="ASC";
    public $sortColumn ="name";
    public $perPage = 10;

    public function doSort($column){
        if($this->sortColumn === $column){
            $this->sortDirection = ($this->sortDirection === 'ASC')? 'DESC':'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when search input is updated
    }
    public function render()
    {
        $user = User::select(
            'name',
            'email',
            'role',
            DB::raw('DATE_FORMAT(created_at, "%b-%d-%Y") as date')
        )->orderBy($this->sortColumn, $this->sortDirection);
        if ($this->search) {
            $user->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('role', 'like', '%' . $this->search . '%')
                  ->orWhere('created_at', 'like', '%' . $this->search . '%');
        }
        $users = $user->paginate($this->perPage);
        
          // Conditionally render the correct view based on user role
        if (auth()->user()->role === 'admin') {
            return view('livewire.admin.user-table', [
                'users' => $users
            ]);
        } elseif (auth()->user()->role === 'owner') {
            return view('livewire.owner.user-table', [
                'users' => $users,
                'userAdmin' =>User::whereNull('role')->get()
            ]);
        } else {
            // Handle if user doesn't have the right role
            abort(403, 'Unauthorized action.');
        }
    }
}
