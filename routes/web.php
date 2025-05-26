<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\NotificationController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [ServiceController::class, 'home']);
Route::get('home', [ServiceController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/services/{category}', [ServiceController::class, 'showServices'])->name('subservices');
// web.php (Routes file)
Route::get('/services', [ServiceController::class, 'services'])->name('customer.services');
Route::get('/getcategories',[ServiceController::class, 'services'])->name('getservices');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/book-service/{id}', [ServiceController::class, 'ServiceBooking'])->name('service.booking');
    Route::post('/submit-booking', [ServiceController::class, 'OrderBooking'])->name('service.order');

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
})->name('admin-dashboard');
Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
Route::get('/cards', function () {
    return view('admin.accepted-requests');
})->name('admin.accepted-requests');
Route::get('/forms', function () {
    return view('admin.forms');
})->name('admin.forms');

Route::get('/admin/inactive-technicians', [AdminController::class, 'inactiveTechnicians'])->name('admin.inactive.technicians');
Route::get('/admin/accepted-technicians/{id}', [AdminController::class, 'AcceptedTechnicians'])->name('admin.technicians.accept');
Route::get('/admin/rejected-technicians/{id}', [AdminController::class, 'RejectedTechnicians'])->name('admin.technicians.reject');
Route::get('/services', [AdminController::class, 'index'])->name('admin.services');
Route::post('/services/category', [AdminController::class, 'storeCategory'])->name('admin.services.storeCategory');
Route::post('/services', [AdminController::class, 'storeService'])->name('admin.services.store');
Route::delete('/services/{service}', [AdminController::class, 'destroyService'])->name('admin.services.delete');
Route::get('/charts', function () {
    return view('admin.manage-services');
})->name('admin.manage-services');
Route::get('/buttons', function () {
    return view('admin.rejected-requests');
})->name('admin.rejected-requests');
Route::get('/modals', function () {
    return view('admin.manage-technician');
})->name('admin.manage-technician');
Route::get('/tables', function () {
    return view('admin.technician-queries');
})->name('admin.technician-queries');
Route::get('/customer-queries', function () {
    return view('admin.customer-queries');
})->name('admin.customer-queries');
Route::get('/admin-login', function () {
    return view('admin.pages.login');
})->name('admin.login');


// -----------------------------------------------------------------------------------
// technician routes

Route::middleware(['auth', 'role:technician'])->group(function () {
  
    Route::get('/tech-dashboard', [TechnicianController::class, 'index'])->name('technician.dashboard');
    Route::get('edit-profile', function () {
        return view('technician.pages.edit_profile');
    })->name('technician.editprofile');
    Route::get('/technician/profile/update', [TechnicianController::class, 'settings'])->name('technician.profile.update');
  
   
    // Show the settings page
Route::get('/technician/settings', [TechnicianController::class, 'settings'])->name('technician.settings');

// Handle form submissions for updating email and password
Route::post('/technician/settings/email', [TechnicianController::class, 'updateEmail'])->name('technician.updateEmail');
Route::post('/technician/settings/password', [TechnicianController::class, 'updatePassword'])->name('technician.updatePassword');

// Handle account deletion
Route::post('/technician/settings/delete', [TechnicianController::class, 'deleteAccount'])->name('technician.deleteAccount');


    Route::get('layouts', function () {
        return view('technician.pages.layout');
    })->name('technician.layout');
    Route::get('pricing', function () {
        return view('technician.pages.pricing');
    })->name('technician.pricing');
    Route::get('order/requests', [OrderController::class, 'order_requests'])->name('technician.orders.requests');
    Route::post('order/view', [OrderController::class, 'view_order'])->name('technician.order.view');

    Route::get('order/pending', [OrderController::class, 'pending_orders'])->name('technician.orders.pending');
   
    Route::get('404', function () {
        return view('technician.pages.404-error');
    })->name('technician.404');
    Route::get('/tech-404', function () {
        return view('technician.pages.completed-orders');
    })->name('technician.orders.completed');


    Route::post('/fare-offer', [OrderController::class, 'Offer_Fair'])->name('technician.fare.offer');

    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('technician.orders.updateStatus');
    Route::post('/orders/status/update', [OrderController::class, 'updateStatus'])->name('technician.orders.updateStatus');



    Route::get('/technician/profile/edit', [TechnicianController::class, 'editProfile'])->name('technician.profile.edit');
    Route::post('/technician/profile/create', [TechnicianController::class, 'createProfile'])->name('technician.profile.create');
    Route::match(['post', 'put'], '/technician/profile/update', [TechnicianController::class, 'updateProfile'])->name('technician.profile.update');
    Route::post('/technician/profile/availability', [TechnicianController::class, 'updateAvailability'])->name('technician.profile.availability');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('technician.notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('technician.notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('technician.notifications.mark-all-as-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('technician.notifications.unread-count');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('technician.notifications.destroy');
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


require __DIR__ . '/auth.php';
