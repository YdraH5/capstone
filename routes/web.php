<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppartmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReportController;
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

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories/index', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{categories}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{categories}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{categories}/delete',[CategoryController::class, 'delete'])->name('categories.delete');
    Route::get('/categories/restore',[CategoryController::class, 'restore'])->name('categories.restore');

    Route::post('/reports/index', [ReportController::class, 'create'])->name('reports.create');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/appartment', [AppartmentController::class, 'index'])->name('appartment.index');
    Route::post('/appartment/index', [AppartmentController::class, 'create'])->name('appartment.create');

});
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware(['auth','verified','isAdmin'])->get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/available', function () {
    return view('available');
})->name('available');

Route::middleware(['auth','isRenter'])->get('renters/index', function () {
    return view('renters.index');
})->name('renters.index');



Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
