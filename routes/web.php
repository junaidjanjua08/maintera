<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', function () {
        return view('404');
    })->name('profile');
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about-us');
Route::get('/contact', function () {
    return view('contact');
})->name('contact-us');
Route::get('/services', function () {
    return view('services');
})->name('services');
Route::get('/subservices', function () {
    return view('subservices');
})->name('subservices');
Route::get('/404', function () {
    return view('404');
})->name('404');




// admin routes
Route::get('/admin-dashboard', function () {
    return view('admin.index');
});



// technician routes
Route::get('/tech-dashboard', function () {
    return view('technician.index');
});
require __DIR__.'/auth.php';
