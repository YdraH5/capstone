<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
class AppartmentController extends Controller
{
  
    public function index(){
        $categories = Category::all();
        $apartment = DB::table('apartment')
        ->join('categories', 'categories.id', '=', 'apartment.category_id')
        ->leftjoin('users', 'users.id', '=', 'apartment.renter_id')
        ->select('categories.name as categ_name','users.name as renters_name','apartment.id','apartment.room_number','apartment.price','apartment.status')
        ->get();
        return view('admin.apartment.index',['categories'=>$categories,'apartment'=>$apartment]);
    }
    public function create(Request $request){
        $data = $request->validate([
            'category_id' => 'required',
            'building' => 'required',
            'room_number'=>'required|numeric',
            'price'=>'required|numeric',
            'status'=>'required|string|max:50'
        ]);
        $newApartment = Appartment::create($data);
        return redirect()->route('admin.apartment.index')->with('success','Apartment added successfully');
    }
    public function edit(Appartment $apartment){
        $categories = Category::all();
        $current_category = DB::table('categories')
        ->where('id',$apartment->category_id)->get();
        foreach($current_category as $current)
        return view('admin.apartment.edit',['apartment' => $apartment,'categories'=>$categories,'current'=>$current]);
    }

    public function update(Appartment $apartment, Request $request)
{
    $data = $request->validate([
        'category_id' => 'required',
        'building' => 'required',
        'room_number' => 'required|numeric',
        'price' => 'required|numeric',
        'status' => 'required|string|max:50'
    ]);
    $apartment->update($data);  

    return redirect(route('admin.apartment.index'))->with('success', 'Apartment updated successfully')->withInput();
}
    public function delete(Appartment $apartment){
        $apartment->delete();
        return redirect(route('admin.apartment.index'))->with('success','Apartment deleted successfully');
     }
}
