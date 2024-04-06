<?php

namespace App\Http\Controllers;

use App\Models\Appartment;
use App\Models\user;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Appartment $apartment){
       
        $apartment = DB::table('apartment')
        ->join('categories', 'categories.id', '=', 'apartment.category_id')
        ->leftjoin('users', 'users.id', '=', 'apartment.renter_id')
        ->leftjoin('category_images', 'category_images.category_id','=','categories.id')
        ->select('categories.name as categ_name','categories.description','apartment.id','apartment.price','apartment.status','category_images.image','category_images.category_id AS categ_id')
        ->where('apartment.id',$apartment->id)
        ->limit(1)
        ->get();
        foreach ($apartment as $categ_id)
        $categories = Category::all()->where('id',$categ_id->categ_id);
        return view('reserve.index',['apartment'=>$apartment,'category'=>$categories]);
    }
    public function form(User $user){

    }
}
