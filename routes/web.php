<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [ServiceController::class, 'home']);
Route::get('home', [ServiceController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/services/{category}', [ServiceController::class, 'showServices'])->name('subservices');

Route::get('/services', [ServiceController::class, 'services'])->name('services');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', function () {
        return view('404');
    })->name('profile');
});

Route::get('/about', function () {
    return view('about');
})->name('about-us');
Route::get('/contact', function () {
    return view('contact');
})->name('contact-us');
Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/404', function () {
    return view('404');
})->name('404');


// -----------------------------------------------------------------------------------
// admin routes
Route::get('/admin-dashboard', function () {
    return view('admin.index');
});
Route::get('/cards', function () {
    return view('admin.cards');
})->name('admin.cards');
Route::get('/forms', function () {
    return view('admin.forms');
})->name('admin.forms');
Route::get('/charts', function () {
    return view('admin.charts');
})->name('admin.charts');
Route::get('/buttons', function () {
    return view('admin.buttons');
})->name('admin.buttons');
Route::get('/modals', function () {
    return view('admin.modals');
})->name('admin.modals');
Route::get('/tables', function () {
    return view('admin.tables');
})->name('admin.tables');
Route::get('/admin-login', function () {
    return view('admin.pages.login');
})->name('admin.login');


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
