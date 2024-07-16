<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VisitorPageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SubmitReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotifyMeController;

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
Route::group(['middleware' => ['auth','verified' ,'sessionTimeout']], function () {

Route::get('pay',[PaymentController::class,'pay']);
Route::get('success',[PaymentController::class,'success']);

    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('/dashboard', function () {
            return view('/dashboard');
        })->name('dashboard');
  
        Route::controller(ImageController::class)->group(function() {
            Route::get('/admin/categories/{categoryId}/upload', 'index');
            Route::post('/admin/categories/{categoryId}/upload', 'store');
            Route::get('/admin/category-image/{categoryImageId}/delete', 'delete');
        });
        // ROUTE TO USERS DATA TABLE
        Route::get('/admin/users', function () {
            return view('/admin/users');
        })->name('admin.users.index');

        // ROUTE TO MANAGING APARTMENT CATEGORIES
        Route::get('/admin/categories', function () {
            return view('/admin/categories');
        })->name('admin.categories.index');

        // ROUTE TO REPORTS INDEX PAGE FOR ADMIN
        Route::get('/admin/reports', function () {
            return view('/admin/reports');
        })->name('admin.reports.index');

        // ROUTE TO APARTMENT CONTROL PAGE FOR ADMIN
        Route::get('/admin/apartment', function () {
            return view('/admin/apartment');
        })->name('admin.apartment.index');

        // ROUTE TO PAYMENT CONTROL PAGE FOR ADMIN
        Route::get('/admin/payments', function () {
            return view('/admin/payments');
        })->name('admin.payments.index');

        // ROUTE TO RESERVATION MANAGEMENT FOR ADMIN
        Route::get('/admin/reservations', function () {
            return view('/admin/reservations');
        })->name('admin.reserve.index');
    });
    
    // ROUTING group for reserved users only users who have pending reservation have access here
    Route::group(['middleware' => ['isReserve','verified']], function () {
        Route::get('/reserve/edit',[ReservationController::class,'edit'])->name('reserve.edit');
        Route::get('/reserve/{id}/{apartment}/{reservation}/update',[ReservationController::class,'update'])->name('reserve.update');
    });
    Route::group(['middleware' => ['isRenter','verified']], function () {
        Route::controller(SubmitReportController::class)->group(function() {
            Route::get('/renters/report','index')->name('renters.report');
            Route::get('/renters/{report_id}/view','view')->name('renters.report.view');
            Route::post('/renters/create','create')->name('renters.report.create');
        });
        Route::get('/renters/payment', function () {
            return view('/renters/payment');
        })->name('renters.payment');
        Route::get('/renters/home', function () {
            return view('/renters/home');
        })->name('renters.home');
    });
Route::get('/notify', [NotifyMeController::class, 'notify'])->name('emails.notify')->middleware(['auth', 'verified']);
Route::get('/reserve/{apartment}/index',[ReservationController::class,'index'])->name('reserve.index')->middleware(['auth', 'verified']);
Route::post('/reserve/create',[ReservationController::class,'create'])->name('reserve.create')->middleware(['auth', 'verified']);;


});


// first page to see when url of the page is executed
Route::get('/', function () {
    return view('/visitors/index');
})->name('welcome');
// Route::get('/', function () {
//     $subject = 'test subject';
//         $body = 'Test MEssage';
//         Mail::to('hardyaranzanso0930@gmail.com')->send(new Mailing($subject,$body));
// })->name('mail');


Route::get('/reserve/wait',[ReservationController::class,'waiting'])->name('reserve.wait');        

// route to see the full details for a certain apartment
Route::get('visitors/{apartment}/detail',[VisitorPageController::class,'display'])->name('visitors.display');

// all types of user that is currently logged in should have access in profile module to update or delete their profile
Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
