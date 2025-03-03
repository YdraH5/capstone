<?php

namespace App\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\User;
use App\Models\Nearby;
class WelcomePage extends Component
{
    public $priceFilter;
    public $viewDetailModal="false";
    public $selected_id;
    public $roomTypeFilter;
    public $images =[];
    public $apartments;
    public function viewDetails($categoryId)
    {
        return redirect()->route('visitors.display', ['apartment' => $categoryId]);
    }
    public function closeModal(){
        $this->viewDetailModal = false;
        $this->selected_id = null;
    }
    public function render()
    {
        $query = DB::table('apartment')
            ->leftJoin('categories', 'categories.id', '=', 'apartment.category_id')
            ->leftJoin('users', 'users.id', '=', 'apartment.renter_id')
            ->select(
                'categories.id as category_id',
                'categories.name as category_name',
                'categories.description',
                'categories.price',
                DB::raw('COUNT(apartment.id) as apartment_count')
            )
            ->groupBy('categories.id', 'categories.name', 'categories.description', 'categories.price')
            ->get();
    
        $this->apartments = $query;
    
        foreach ($this->apartments as $category) {
            $categoryImages = DB::table('category_images')
                ->where('category_id', $category->category_id)
                ->get();
            $this->images[$category->category_id] = $categoryImages;
        }
        $owner = User::where('role', 'owner')->first();
        $nearby= Nearby::all();
        return view('livewire.welcome-page', [
            'categories' => $this->apartments,
            'owner' => $owner,
            'nearby' => $nearby,
            'images' => $this->images,
        ]);
    }
}    