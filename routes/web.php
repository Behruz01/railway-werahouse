<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'admin' ,'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'admin'],], function(){
    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('drivers', 'drivers')->name('drivers');
        Route::get('admins', 'admins')->name('admins');
        Route::get('admins', 'vans')->name('vans');
        Route::get('wagons', 'wagons')->name('wagons');
        Route::get('orders', 'orders')->name('orders');
        Route::get('rotas', 'rotas')->name('rotas');
        Route::get('add-shift', 'addShift')->name('addShift');
        Route::get('add-driver', 'addDriver')->name('addDriver');
        Route::get('add-admin', 'addAdmin')->name('addAdmin');
        Route::get('profile/{user:uuid}', 'profile')->name('profile');
        Route::get('settings/{user:uuid}', 'settings')->name('settings');
        Route::resource('users', UserController::class);
    });
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
    Route::middleware(['auth'])->group(function () {
    // Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('orders.user');
});
});

require __DIR__.'/auth.php';
