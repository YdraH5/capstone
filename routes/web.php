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
use App\Http\Controllers\SubmitReportController;
use App\Http\Controllers\RenterController;
use Illuminate\Support\Facades\DB;


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
Route::middleware(['auth','verified'])->group( function(){
    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('/dashboard',[AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
  
        Route::controller(ImageController::class)->group(function() {
            Route::get('/admin/categories/{categoryId}/upload', 'index');
            Route::post('/admin/categories/{categoryId}/upload', 'store');
            Route::get('/admin/category-image/{categoryImageId}/delete', 'delete');
        });
        // ROUTE TO USERS DATA TABLE
        Route::get('/admin/users/index', function () {
            return view('/admin/users/index');
        })->name('admin.users.index');

        // ROUTE TO MANAGING APARTMENT CATEGORIES
        Route::get('/admin/categories/index', function () {
            return view('/admin/categories/index');
        })->name('admin.categories.index');

        // ROUTE TO REPORTS INDEX PAGE FOR ADMIN
        Route::get('/admin/reports/index', function () {
            return view('/admin/reports/index');
        })->name('admin.reports.index');

        // ROUTE TO APARTMENT CONTROL PAGE FOR ADMIN
        Route::get('/admin/apartment/index', function () {
            return view('/admin/apartment/index');
        })->name('admin.apartment.index');

        // ROUTE TO RESERVATION MANAGEMENT FOR ADMIN
        Route::get('/admin/reserves/index', function () {
            return view('/admin/reserves/index');
        })->name('admin.reserve.index');
    });
});
    
    // ROUTING group for reserved users only users who have pending reservation have access here
    Route::group(['middleware' => ['auth','isReserve']], function () {
        Route::get('/reserve/wait',[ReservationController::class,'waiting'])->name('reserve.wait');
        Route::get('/reserve/edit',[ReservationController::class,'edit'])->name('reserve.edit');
        Route::get('/reserve/{id}/{apartment}/{reservation}/update',[ReservationController::class,'update'])->name('reserve.update');
    });
    Route::group(['middleware' => ['auth','isRenter']], function () {
        Route::controller(SubmitReportController::class)->group(function() {
            Route::get('/renters/home','home')->name('renters.home');
            Route::get('/renters/report/index','index')->name('renters.report.index');
            Route::get('/renters/report/{report_id}/view','view')->name('renters.report.view');
            Route::post('/renters/report/create','create')->name('renters.report.create');
        });
    });


Route::get('/reserve/{apartment}/index',[ReservationController::class,'index'])->name('reserve.index')->middleware('auth');
Route::post('/reserve/create',[ReservationController::class,'create'])->name('reserve.create');



// first page to see when url of the page is executed
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

// route to see the full details for a certain apartment
Route::get('visitors/{apartment}/detail',[VisitorPageController::class,'display'])->name('visitors.display');

// all types of user that is currently logged in should have access in profile module to update or delete their profile
Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
