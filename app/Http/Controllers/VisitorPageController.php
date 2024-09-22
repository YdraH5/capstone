<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
class VisitorPageController extends Controller
{

    // for viewing full details
    public function display(Category $apartment) {
        // Get category details
        // dd($apartment);
        $category = DB::table('categories')
            ->where('id', $apartment->id)
            ->first();
    
        // Get apartments with the specified category ID and status 'Available'
        $apartments = DB::table('apartment')
            ->leftJoin('users', 'users.id', '=', 'apartment.renter_id')
            ->leftJoin('categories', 'categories.id', '=', 'apartment.category_id')
            ->select('categories.name as categ_name', 'categories.description', 'categories.price', 'apartment.id', 'apartment.status')
            ->where('apartment.category_id', $apartment->id)
            ->where('apartment.status', 'Available')
            ->limit(1)
            ->get();
    
        // Count available apartments
        $available = DB::table('apartment')
            ->where('category_id', $apartment->id)
            ->where('status', 'Available')
            ->count();
    
        // Get category images
        $categoryImages = DB::table('category_images')
            ->where('category_id', $apartment->id)
            ->get();
    
        // Organize images
        $images = [];
        if ($apartments->isNotEmpty()) {
            foreach ($apartments as $apartment) {
                $images[$apartment->id] = $categoryImages;
            }
        } else {
            // Add a dummy entry if no apartments are available
            $apartments = collect([
                (object)[
                    'categ_name' => $category->name,
                    'description' => $category->description,
                    'id' => 0, // Dummy ID for handling in view
                    'price' => $category->price,
                    'status' => 'Unavailable',
                    'categ_id' => $category->id,
                ]
            ]);
            $images[0] = $categoryImages; // Associate images with the dummy ID
        }
    
        return view('visitors.detail', [
            'apartment' => $apartments,
            'images' => $images,
            'available' => $available
        ]);
    }
    
}    