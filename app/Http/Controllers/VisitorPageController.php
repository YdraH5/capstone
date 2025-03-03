<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class VisitorPageController extends Controller
{
    // For viewing full details
    public function display(Category $apartment)
    {
        // Get category details
        $categ_id = $apartment->id;
        $category = DB::table('categories')
            ->where('id', $apartment->id)
            ->first();

        // Get apartments with the specified category ID and status 'Available'
        $apartments = DB::table('apartment')
            ->leftJoin('users', 'users.id', '=', 'apartment.renter_id')
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->select(
                'categories.name as categ_name',
                'categories.id as categ_id',
                'categories.description',
                'categories.price',
                'apartment.id',
                'apartment.status',
                'apartment.room_number'
            )
            ->where('apartment.category_id', $apartment->id)
            ->where('apartment.status', 'Available')
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
            // Ensure images are passed even if no rooms are available
            $images = [];
            if ($apartments->isNotEmpty()) {
                foreach ($apartments as $apartment) {
                    $images[$apartment->id] = $categoryImages;
                }
            } else {
                // Add fallback images for the category when no apartments are available
                $images['fallback'] = $categoryImages;
            }
        }

        return view('visitors.detail', [
            'room_available' => $apartments,
            'apartment' => $apartment,
            'categ_id' => $categ_id,
            'images' => $images,
            'available' => $available,
            'category' => $category // Pass category for additional details
        ]);
    }
}
