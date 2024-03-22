<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
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

    public function delete(Category $categories){
        $categories->delete();
        return redirect(route('categories.index'))->with('success','Category deleted successfully');
    }
}
