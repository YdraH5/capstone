<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
class VisitorPageController extends Controller
{

    // for viewing full details
    public function display(Category $apartment){
        $apartments = DB::table('apartment')
            ->join('categories', 'categories.id', '=', 'apartment.category_id')
            ->leftjoin('users', 'users.id', '=', 'apartment.renter_id')
            ->leftjoin('category_images', 'category_images.category_id','=','categories.id')
            ->select('categories.name as categ_name','categories.description','apartment.id','categories.price','apartment.status','category_images.image','category_images.category_id AS categ_id')
            ->where('apartment.category_id', $apartment->id)
            ->limit(1)
            ->get();
        $available = Appartment::where('category_id',$apartment->id)
            ->where('status','Available')
            ->count();
        $images = [];
        foreach ($apartments as $apartment) {
            $categoryImages = DB::table('category_images')
                ->where('category_id', $apartment->categ_id)
                ->get();
            $images[$apartment->id] = $categoryImages;
        }
    
        return view('visitors.detail', ['apartment' => $apartments, 'images' => $images,'available'=>$available]);
    }
    
}
