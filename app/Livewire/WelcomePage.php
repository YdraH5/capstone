<?php

namespace App\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WelcomePage extends Component
{
    public $priceFilter;
    public $viewDetailModal="false";
    public $selected_id;
    public $roomTypeFilter;
    public $images =[];
    public $apartments;
    public function viewDetail($id){
        $this->selected_id = $id;
        $this->viewDetailModal = true;
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
    
        return view('livewire.welcome-page', [
            'categories' => $this->apartments,
            'images' => $this->images,
        ]);
    }
}    