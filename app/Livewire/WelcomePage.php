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
        ->leftjoin('categories', 'categories.id', '=', 'apartment.category_id')
        ->leftjoin('users', 'users.id', '=', 'apartment.renter_id')
        ->select('apartment.id','categories.id','categories.name as categ_name','categories.description','apartment.price','apartment.status');

    $this->apartments = $query->whereNot('apartment.status', 'Unavailable')->get();
        foreach ($this->apartments as $category){
            $category_id = $category->id;
            $categoryImages = DB::table('category_images')
                        ->where('category_id', $category_id)
                        ->get();
        $this->images[$category->id] = $categoryImages;
        }
        return view('livewire.welcome-page', [
            'apartment' => $this->apartments,
            'images' => $this->images,
        ]);    
        
    }
}
