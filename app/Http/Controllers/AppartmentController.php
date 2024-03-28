<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartment;
use App\Models\Category;
class AppartmentController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view("appartment.index",['categories'=>$categories]);
    }
    public function create(Request $request){
        $data = $request->validate([
            'category_id' => 'required', 'numeric',
            'price'=>'required|numeric',
            'status'=>'required|string|max:50'
        ]);

        $newCategory = Appartment::create($data);
        return redirect()->route('appartment.index')->with('success','Appartment added successfully');
    }
}
