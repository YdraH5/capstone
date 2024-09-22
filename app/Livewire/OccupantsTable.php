<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appartment;
use App\Models\Category;
use App\Models\User;
use App\Models\Building;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class OccupantsTable extends Component
{
    use WithPagination;

    public function render()
    {
            // Start the query with the Apartment model and join the necessary relationships
            $query = Appartment::with(['categories', 'buildings', 'users'])
            ->select(
                'users.name as renters_name',
                'users.role',
                'users.phone_number',
                'users.email',
                'apartment.id',
                'categories.name as categ_name',
                'apartment.room_number',
                'categories.price',
                'buildings.name as building_name',
                DB::raw('DATE_FORMAT(apartment.created_at, "%b-%d-%Y") as date')
            )
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->join('buildings','buildings.id', '=', 'apartment.building_id')
            ->leftJoin('users', 'users.id', '=', 'apartment.renter_id')
            ->where('users.role','renter');
        // Filter based on the search
        if (!empty($this->search)) {
            $query->where(function($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%')
                ->orWhere('users.phone_number', 'like', '%' . $this->search . '%')
                ->orWhere('users.email', 'like', '%' . $this->search . '%')
                ->orWhere('categories.name', 'like', '%' . $this->search . '%')
                ->orWhere('apartment.room_number', 'like', '%' . $this->search . '%')
                ->orWhere('buildings.name', 'like', '%' . $this->search . '%');
            });
        }
    
        // Execute the query and return the results
        $apartments = $query->paginate(10);
    
        return view('livewire.admin.occupants-table', [
            'apartment' => $apartments, // Make sure this matches in the view
            'categories' => Category::all(),
            'buildings' => Building::all()
        ]);
    }
    
}
