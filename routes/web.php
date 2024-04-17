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
        Route::get('/livewire/admin/dashboard', function () {
            return view('/livewire/admin/dashboard');
        })->name('dashboard');
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
  
        Route::controller(ImageController::class)->group(function() {
            Route::get('/admin/categories/{categoryId}/upload', 'index');
            Route::post('/admin/categories/{categoryId}/upload', 'store');
            Route::get('/admin/category-image/{categoryImageId}/delete', 'delete');
        });
        // ROUTE TO USERS DATA TABLE
        Route::get('/livewire/admin/user/index', function () {
            return view('/livewire/admin/user/index');
        })->name('admin.users.index');

        // ROUTE TO MANAGING APARTMENT CATEGORIES
        Route::get('/livewire/admin/category/index', function () {
            return view('/livewire/admin/category/index');
        })->name('admin.categories.index');

        // ROUTE TO REPORTS INDEX PAGE FOR ADMIN
        Route::get('/livewire/admin/report/index', function () {
            return view('/livewire/admin/report/index');
        })->name('admin.reports.index');

        // ROUTE TO APARTMENT CONTROL PAGE FOR ADMIN
        Route::get('/livewire/admin/apartment/index', function () {
            return view('/livewire/admin/apartment/index');
        })->name('admin.apartment.index');

        // ROUTE TO RESERVATION MANAGEMENT FOR ADMIN
        Route::get('/livewire/admin/reserve/index', function () {
            return view('/livewire/admin/reserve/index');
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
    return view('/visitors/index');
})->name('welcome');



// route to see the full details for a certain apartment
Route::get('visitors/{apartment}/detail',[VisitorPageController::class,'display'])->name('visitors.display');

// all types of user that is currently logged in should have access in profile module to update or delete their profile
Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/session','App\Http\Controllers\StripeController@session')->name('session');

require __DIR__.'/auth.php';
