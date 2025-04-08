<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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


// -----------------------------------------------------------------------------------
// admin routes
Route::get('/admin-dashboard', function () {
    return view('admin.index');
});


// -----------------------------------------------------------------------------------
// technician routes

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('tech-dashboard', function () {
        return view('technician.index');
    })->name('technician.dashboard');
    Route::get('edit-profile', function () {
        return view('technician.pages.edit_profile');
    })->name('technician.editprofile');
    Route::get('settings', function () {
        return view('technician.pages.settings');
    })->name('technician.settings');
    Route::get('layouts', function () {
        return view('technician.pages.layout');
    })->name('technician.layout');
    Route::get('pricing', function () {
        return view('technician.pages.pricing');
    })->name('technician.pricing');
    Route::get('order/requests', function () {
        return view('technician.pages.order-requests');
    })->name('technician.orders.requests');
    Route::get('order/pending', function () {
        return view('technician.pages.pending-orders');
    })->name('technician.orders.pending');
    Route::get('order/completed', function () {
        return view('technician.pages.completed-orders');
    })->name('technician.orders.completed');
});



// Route::get('/technnician-dashboard', function () {
//     return view('technician.index');
// })->name('technician.dashboard');
// Route::get('/tech-login', function () {
//     return view('technician.pages.sign-in');
// })->name('tech-login');
// Route::get('/tech-register', function () {
//     return view('technician.pages.sign-up');
// })->name('tech-register');


require __DIR__.'/auth.php';
