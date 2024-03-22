<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppartmentController;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// route to users index page and display all users
Route::get('/users/index', function () {
    $users = User::all();//to get users data from database
    return view("users.index", ['users'=>$users]);//to pass the data to the index page
})->middleware(['auth', 'verified'])->name('users.index');

// route to appartment index page
Route::get('/appartment/index', function () {
    $categories = Category::all('id','name', 'description');
    return view("appartment.index",['categories'=>$categories]);
})->middleware(['auth', 'verified'])->name('appartment.index');

// route to categories index page
Route::get('/categories/index', function () {
    $categories = Category::all();//to get categories data from database
    return view("categories.index", ['categories'=>$categories]);//to pass the data to the index page
})->middleware(['auth', 'verified'])->name('categories.index');

// route to create new category
Route::post('/categories/index', [CategoryController::class, 'create'])->name('categories.create');

// route to edit category
Route::get('/categories/{categories}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

// route to update to category
Route::put('/categories/{categories}/update', [CategoryController::class, 'update'])->name('categories.update');

Route::delete('/categories/{categories}/delete', [CategoryController::class, 'delete'])->name('categories.delete');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
