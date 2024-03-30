<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $categories = Category::all();
        return view("categories.index", ['categories'=>$categories]);
    }
    public function create(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:'.Category::class],
            'description'=>'required|max:250'
        ]);

        $newCategory = Category::create($data);
        return redirect()->route('categories.index')->with('success','Category added successfully');
    }
    public function edit(Category $categories){
        return view('categories.edit',['categories' => $categories]);
    }

    public function update(Category $categories, Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'description'=>'required|max:250'
        ]);
        $categories->update($data);
        return redirect(route('categories.index'))->with('success','Category updated successfully');
    }

    // soft delete the data 
    public function delete(Category $categories){
       $categories->delete();
       return redirect(route('categories.index'))->with('success','Category deleted successfully');
    }

    // show trash data or deleted data 
    // NOTE: this is not yet shown in the frontend
    public function trash(){
        $Category = Category::onlyTrashed()->latest()->get();
    }

    // to restore all the deleted data
    // NOTE: not yet shown in the frontend but working
    public function restore(){
        Category::whereNotNull('deleted_at')->restore();
        return redirect(route('categories.index'))->with('success','Category restored successfully');
    }
   
}
