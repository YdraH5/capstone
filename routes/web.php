<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppartmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VisitorPageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Images;
use App\Models\Report;

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
// specify landing page 
Route::middleware(['auth','isAdmin','verified'])->group( function(){
    // Route::get('/users', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // controller group for category
    Route::controller(CategoryController::class)->group(function() {
        Route::get('/categories/index', 'index')->name('categories.index');
        Route::post('/categories/index', 'create')->name('categories.create');
        Route::get('/categories/{categories}/edit', 'edit')->name('categories.edit');
        Route::put('/categories/{categories}/update', 'update')->name('categories.update');
        Route::delete('/categories/{categories}/delete', 'delete')->name('categories.delete');
        Route::get('/categories/restore','restore')->name('categories.restore');
    });
    // controller group for report
    Route::controller(ReportController::class)->group(function() {
        Route::post('/reports/create','create')->name('reports.create');
        Route::get('/reports', 'index')->name('reports.index');
    });
    // controller group for category
    Route::controller(AppartmentController::class)->group(function() {
        Route::get('/appartment', 'index')->name('appartment.index');
        Route::post('/appartment/create', 'create')->name('appartment.create');
        Route::get('/appartment/{apartment}/edit', 'edit')->name('appartment.edit');
        Route::put('/appartment/{apartment}/update', 'update')->name('appartment.update');
        Route::delete('/appartment/{apartment}/delete', 'delete')->name('appartment.delete');
    });
    Route::controller(ImageController::class)->group(function() {
        Route::get('/categories/{categoryId}/upload', 'index');
        Route::post('/categories/{categoryId}/upload', 'store');
        Route::get('/category-image/{categoryImageId}/delete', 'delete');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

 });
Route::get('/', function () {
    $apartment = DB::table('apartment')
        ->leftjoin('categories', 'categories.id', '=', 'apartment.category_id')
        ->leftjoin('users', 'users.id', '=', 'apartment.renter_id')
        ->select('apartment.id','categories.id','categories.name as categ_name','categories.description','apartment.price','apartment.status')
        ->get();
    $images=[];
        foreach ($apartment as $category){
            $category_id = $category->id;
            $categoryImages = DB::table('category_images')
                        ->where('category_id', $category_id)
                        ->get();
        $images[$category->id] = $categoryImages;
        }
    return view('/visitors/index',compact('apartment', 'images'));
})->name('welcome');

Route::get('visitors/{apartment}/detail',[VisitorPageController::class,'display'])->name('visitors.display');

// Route::get('/renters/{apartment}/index',[ReservationController::class,'index'])->name('reserve.form');
Route::middleware(['auth'])->group( function(){
    Route::get('/reserve/{apartment}/index',[ReservationController::class,'index'])->name('reserve.index');
});

Route::middleware(['auth','verified','isAdmin'])->get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/available', function () {
    return view('available');
})->name('available');

Route::middleware(['auth','isRenter'])->get('renters/index', function () {
    return view('renters.index');
})->name('renters.index');


require __DIR__.'/auth.php';
