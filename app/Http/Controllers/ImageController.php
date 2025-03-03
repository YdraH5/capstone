<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Images;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\CategoryController;

class ImageController extends Controller
{
  public function index(int $categoryId)
  {
    $category = Category::findorFail($categoryId);

    $categoryImages = Images::where('category_id',$categoryId)->get();
    return view('/owner/category-images/index',compact('category','categoryImages'));
  }
  
  public function store(Request $request,int $categoryId)
  {
      $request->validate([
          'images.*' => 'required|image|mimes:png,jpg,jpeg',
      ]);
      $category = Category::findOrFail($categoryId);
      $imageData = [];
      if($files = $request->file('images')){
        foreach($files as$key => $file){
            $extension = $file->getClientOriginalExtension();
            $filename =$key.'-' .time(). '.' .$extension;

            $path = "uploads/categories/";

            $file->move($path, $filename);

            $imageData[] = [
                'category_id' => $category->id,
                'image'=>$path.$filename,
            ];  

        }
      }
      Images::insert($imageData);
      return redirect()->back()->with('success','Uploaded Successfully');
  }      
  public function edit($id)
  {

  }  
  public function description(Request $request, $categoryId)
  {
      // Validate the request data
      $data = $request->validate([
          'description' => 'required|string|max:255'
      ]);
  
      // Find the image by ID
      $image = Images::find( $categoryId);
  
      // Check if the image exists
      if (!$image) {
          return redirect()->back()->with('error', 'Image not found');
      }
  
      // Update the description
      $image->update([
          'description' => $data['description']
      ]);
  
      // Redirect back with a success message
      return redirect()->back()->with('success', 'Description updated successfully');
  }
  
  public function delete(int $categoryImageId){
    $categoryImage = Images::findOrFail($categoryImageId);
    if(File::exists($categoryImage->image)){
        File::exists($categoryImage->image);
    }
    $categoryImage->delete();

    return redirect()->back()->with('success','Image Deleted');
  }
    
}

