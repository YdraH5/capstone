<?php

namespace App\Livewire;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WelcomePage extends Component
{
    public $priceFilter;
    public $roomTypeFilter;
    public $images =[];
    public function render()
    {
        $query = DB::table('apartment')
        ->leftjoin('categories', 'categories.id', '=', 'apartment.category_id')
        ->leftjoin('users', 'users.id', '=', 'apartment.renter_id')
        ->select('apartment.id','categories.id','categories.name as categ_name','categories.description','apartment.price','apartment.status');
            // Apply filters
        // if ($this->priceFilter) {
        //     $query->where('apartment.price', $this->priceFilter);
        // }
        
        if ($this->roomTypeFilter) {
            $query->where('categories.name', $this->roomTypeFilter);
        }

        // if ($this->peopleFilter) {
        //     // You need to adjust this based on how your database is structured
        //     // This is just an example assuming you have a column named 'capacity' in the 'categories' table
        //     $query->where('categories.capacity', '>=', $this->peopleFilter);
        // }

    $apartments = $query->whereNot('apartment.status', 'Unavailable')->get();
        foreach ($apartments as $category){
            $category_id = $category->id;
            $categoryImages = DB::table('category_images')
                        ->where('category_id', $category_id)
                        ->get();
        $this->images[$category->id] = $categoryImages;
        $images = $this->images;
        }
        return view('livewire.welcome-page', [
            'apartment' => $apartments,
            'images' => $images,
        ]);    
        
    }
}
