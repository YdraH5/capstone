<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VisitorPageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SubmitReportController;
use App\Http\Controllers\NotifyMeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\RenterController;
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
Route::group(['middleware' => ['auth','verified']], function () {

    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');


        // ROUTE TO USERS DATA TABLE
        Route::get('/admin/users', function () {
            return view('/admin/users');
        })->name('admin.users.index');

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

        // ROUTE TO BUILDING MANAGEMENT FOR ADMIN
        Route::get('/admin/occupants', function () {
            return view('/admin/occupants');
        })->name('admin.occupants.index');
    });
    
    //route group for owner pages
    Route::group(['middleware' => ['isOwner']], function () {
        Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
        Route::controller(ImageController::class)->group(function() {
            Route::get('/owner/categories/{categoryId}/upload', 'index');
            Route::get('/owner/categories/{categoryId}/edit', 'edit');
            Route::post('/owner/categories/{categoryId}/description', 'description');
            Route::post('/owner/categories/{categoryId}/upload', 'store');
            Route::get('/owner/category-image/{categoryImageId}/delete', 'delete');
        });
        // ROUTE TO USERS DATA TABLE
        Route::get('/owner/users', function () {
            return view('/owner/users');
        })->name('owner.users.index');

        // ROUTE TO MANAGING APARTMENT CATEGORIES
        Route::get('/owner/categories', function () {
            return view('/owner/categories');
        })->name('owner.categories.index');

        // ROUTE TO REPORTS INDEX PAGE FOR owner
        Route::get('/owner/reports', function () {
            return view('/owner/reports');
        })->name('owner.reports.index');

        // ROUTE TO APARTMENT CONTROL PAGE FOR owner
        Route::get('/owner/apartment', function () {
            return view('/owner/apartment');
        })->name('owner.apartment.index');

        // ROUTE TO PAYMENT CONTROL PAGE FOR owner
        Route::get('/owner/payments', function () {
            return view('/owner/payments');
        })->name('owner.payments.index');

        // ROUTE TO RESERVATION MANAGEMENT FOR owner
        Route::get('/owner/reservations', function () {
            return view('/owner/reservations');
        })->name('owner.reserve.index');

        // ROUTE TO BUILDING MANAGEMENT FOR owner
        Route::get('/owner/building', function () {
            return view('/owner/building');
        })->name('owner.building.index');

        // ROUTE TO BUILDING MANAGEMENT FOR owner
        Route::get('/owner/occupants', function () {
            return view('/owner/occupants');
        })->name('owner.occupants.index');
    });


    // ROUTING group for reserved users only users who have pending reservation have access here
    Route::group(['middleware' => ['isReserve','verified']], function () {
        Route::get('/reserve/edit',[ReservationController::class,'edit'])->name('reserve.edit');
        Route::get('/reserve/{id}/{apartment}/{reservation}/update',[ReservationController::class,'update'])->name('reserve.update');
    });
    Route::group(['middleware' => ['isRenter','verified']], function () {
        Route::controller(SubmitReportController::class)->group(function() {
            // Route::get('/renters/report','index')->name('renters.report');
            Route::get('/renters/{report_id}/view','view')->name('renters.report.view');
            Route::post('/renters/create','create')->name('renters.report.create');


        });
        Route::get('/renters/home',[RenterController::class,'index'])->name('renters.home');        
        Route::get('/renters/{id}/{apartment}/{reservation}/resend',[RenterController::class,'resend'])->name('renters.resend');
        Route::post('/renters/extend',[RenterController::class,'extend'])->name('renters.extend');
        Route::post('/renters/pay',[RenterController::class,'pay'])->name('renters.pay');
        Route::get('/renters/paid',[RenterController::class,'paymentSuccess'])->name('renters.paid');
        Route::get('/renters/downloadContract/{user_id}/{apartment_id}/{reservation_id}', [RenterController::class, 'downloadContract'])->name('renters.downloadContract');


        Route::get('/renters/payment', function () {
            return view('/renters/payment');
        })->name('renters.payment');
        Route::get('/renters/report', function () {
            return view('/renters/report');
        })->name('renters.report');
    });
Route::get('/notify', [NotifyMeController::class, 'notify'])->name('emails.notify')->middleware(['auth', 'verified']);
Route::get('/contract', [ReservationController::class, 'contract'])->name('emails.contract')->middleware(['auth', 'verified','isRenter']);

Route::get('/reserve/{apartment}/index',[ReservationController::class,'index'])->name('reserve.index')->middleware(['auth', 'verified']);
Route::post('/reserve/create',[ReservationController::class,'create'])->name('reserve.create')->middleware(['auth', 'verified']);
Route::get('/reserve/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reserve.cancel');
Route::get('/payment-success', [ReservationController::class, 'paymentSuccess'])->name('reserve.payment_success')->middleware(['auth', 'verified']);
});


// first page to see when url of the page is executed
Route::get('/', function () {
    return view('/visitors/index');
})->name('welcome')->middleware('guest');
Route::get('/visitors/index', [VisitorPageController::class, 'index'])->name('visitors.index');


// 
Route::get('/reserve/wait',[ReservationController::class,'waiting'])->name('reserve.wait')->middleware('isReserve');        

// route to see the full details for a certain apartment
Route::get('visitors/{apartment}/detail',[VisitorPageController::class,'display'])->name('visitors.display');

// all types of user that is currently logged in should have access in profile module to update or delete their profile
Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
