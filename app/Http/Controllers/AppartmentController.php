<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartment;
class AppartmentController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
            'category_id' => 'required', 'numeric',
            'price'=>'required|numeric',
            'status'=>'required|string|max:50'
        ]);

        $newCategory = Appartment::create($data);
        return redirect()->route('categories.index')->with('success','Category added successfully');
    }
}
