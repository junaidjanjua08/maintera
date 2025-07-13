<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;

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

    // Customer Orders Route
    Route::get('/customer/orders', [OrderController::class, 'customerOrders'])->name('customer.orders');
});


Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('/payment/easypaisa', [PaymentController::class, 'payWithEasypaisa'])->name('payment.easypaisa');
Route::match(['get', 'post'], '/payment/easypaisa/callback', [PaymentController::class, 'easypaisaCallback'])->name('payment.easypaisa.callback');

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
Route::middleware(['auth', 'IsAdmin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin.index');
    })->name('admin-dashboard');
    Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
    Route::get('/technicians/rejected', [AdminController::class, 'rejectedTechnicians'])->name('admin.rejected-requests');
    Route::get('/forms', function () {
        return view('admin.forms');
    })->name('admin.forms');

    Route::get('/admin/inactive-technicians', [AdminController::class, 'inactiveTechnicians'])->name('admin.inactive.technicians');
    Route::get('/admin/accepted-technicians/{id}', [AdminController::class, 'AcceptedTechnicians'])->name('admin.technicians.accept');
    Route::get('/admin/rejected-technicians/{id}', [AdminController::class, 'RejectedTechnicians'])->name('admin.technicians.reject');
    Route::patch('/admin/technicians/{technician}/toggle-status', [AdminController::class, 'toggleTechnicianStatus'])->name('admin.technicians.toggle-status');
    Route::delete('/admin/technicians/{technician}/delete', [AdminController::class, 'deleteTechnician'])->name('admin.technicians.delete');

    Route::get('/services', [AdminController::class, 'index'])->name('admin.services');
    Route::post('/services/category', [AdminController::class, 'storeCategory'])->name('admin.services.storeCategory');
    Route::post('/services', [AdminController::class, 'storeService'])->name('admin.services.store');
    Route::delete('/services/{service}', [AdminController::class, 'destroyService'])->name('admin.services.delete');
    Route::delete('/services/category/{category}', [AdminController::class, 'destroyCategory'])->name('admin.services.deleteCategory');
    Route::get('/charts', function () {
        return view('admin.manage-services');
    })->name('admin.manage-services');
    Route::get('/technicians/accepted', [AdminController::class, 'acceptedTechnicians'])->name('admin.accepted-requests');
    Route::get('/manage/technicians', [AdminController::class, 'manageTechnicians'])->name('admin.manage-technician');
    Route::get('/technician-queries', function () {
        return view('admin.technician-queries');
    })->name('admin.technician-queries');
    Route::get('/customer-queries', function () {
        return view('admin.customer-queries');
    })->name('admin.customer-queries');

    Route::get('/support-requests', [AdminController::class, 'supportRequests'])->name('admin.support-requests');

    Route::get('/admin/technicians/{technician}', [AdminController::class, 'viewTechnicianProfile'])->name('admin.technicians.view');
});

// -----------------------------------------------------------------------------------
// technician routes

Route::middleware(['auth', 'role:technician'])->group(function () {
  
    Route::get('/tech-dashboard', [TechnicianController::class, 'index'])->name('technician.dashboard');
    Route::get('edit-profile', [TechnicianController::class, 'editProfile'])->name('technician.editprofile');
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
    Route::get('/order/completed', [OrderController::class, 'completed_orders'])->name('technician.orders.completed');


    Route::post('/fare-offer', [TechnicianController::class, 'Offer_Fair'])->name('technician.fare.offer');

    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('technician.orders.updateStatus');
    Route::post('/orders/status/update', [OrderController::class, 'updateStatus'])->name('technician.orders.updateStatus');
    Route::post('/orders/cancel', [OrderController::class, 'cancelOrder'])->name('technician.orders.cancel');



  
    Route::post('/technician/profile/create', [TechnicianController::class, 'createProfile'])->name('technician.profile.create');
    Route::match(['post', 'put'], '/technician/profile/update', [TechnicianController::class, 'updateProfile'])->name('technician.profile.update');
    Route::post('/technician/profile/availability', [TechnicianController::class, 'updateAvailability'])->name('technician.profile.availability');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('technician.notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('technician.notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('technician.notifications.mark-all-as-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('technician.notifications.unread-count');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('technician.notifications.destroy');
});

// Customer Notification Routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/notifications', [NotificationController::class, 'index'])->name('customer.notifications.index');
    Route::post('/customer/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('customer.notifications.mark-as-read');
    Route::post('/customer/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('customer.notifications.mark-all-as-read');
    Route::get('/customer/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('customer.notifications.unread-count');
    Route::delete('/customer/notifications/{id}', [NotificationController::class, 'destroy'])->name('customer.notifications.destroy');
});

require __DIR__ . '/auth.php';

// Admin Authentication Routes (outside middleware group)
Route::get('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login']);
Route::post('/admin/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout');

// Customer: View all fare offers for an order
Route::get('/customer/orders/{order}/fares', [OrderController::class, 'viewOrderFares'])->name('customer.order.fares');

// Customer: View technician profile
Route::get('/technician/profile/{technician}', [OrderController::class, 'viewTechnicianProfile'])->name('technician.profile.view');

// Customer: Accept a fare offer (assign order to technician)
Route::post('/customer/orders/{order}/fares/{fareOffer}/accept', [OrderController::class, 'acceptFareOffer'])->name('customer.fare.accept');

// Support Routes
Route::post('/support/submit', [SupportController::class, 'submit'])->name('support.submit');
Route::get('/support/stats', [SupportController::class, 'getStats'])->name('support.stats');

// Admin Support Routes
Route::middleware(['auth', 'IsAdmin'])->group(function () {
    Route::get('/admin/support-requests', [SupportController::class, 'index'])->name('admin.support-requests.index');
    Route::get('/admin/support-requests/{supportRequest}', [SupportController::class, 'show'])->name('admin.support-requests.show');
    Route::patch('/admin/support-requests/{supportRequest}/status', [SupportController::class, 'updateStatus'])->name('admin.support-requests.update-status');
    Route::get('/admin/support-requests/{supportRequest}/download/{filename}', [SupportController::class, 'downloadAttachment'])->name('admin.support-requests.download');
    Route::delete('/admin/support-requests/{supportRequest}', [SupportController::class, 'destroy'])->name('admin.support-requests.destroy');
});

// Chat Routes - Customer
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/chat', [ChatController::class, 'index'])->name('customer.chat.index');
    Route::get('/customer/chat/{order}', [ChatController::class, 'show'])->name('customer.chat.show');
    Route::post('/customer/chat/{order}/send', [ChatController::class, 'sendMessage'])->name('customer.chat.send');
    Route::get('/customer/chat/{order}/messages', [ChatController::class, 'getNewMessages'])->name('customer.chat.messages');
    Route::get('/customer/chat/notification-count', [ChatController::class, 'getNotificationCount'])->name('customer.chat.notification-count');
    Route::delete('/customer/chat/message/{message}', [ChatController::class, 'deleteMessage'])->name('customer.chat.delete-message');
    Route::delete('/customer/chat/{order}', [ChatController::class, 'deleteChat'])->name('customer.chat.delete');
    Route::get('/customer/chat/message/{message}/download', [ChatController::class, 'downloadFile'])->name('customer.chat.download');

    // Order Fares Routes
    Route::get('/customer/order-fares', [App\Http\Controllers\OrderFareController::class, 'index'])->name('customer.order.fares.index');
    Route::get('/customer/order-fares/{order}', [App\Http\Controllers\OrderFareController::class, 'show'])->name('customer.order.fares.show');
    Route::post('/customer/order-fares/{order}/accept/{fare}', [App\Http\Controllers\OrderFareController::class, 'acceptFare'])->name('customer.order.fares.accept');
    Route::get('/customer/order-fares/stats', [App\Http\Controllers\OrderFareController::class, 'getFareStats'])->name('customer.order.fares.stats');

    // Review Routes - Customer
    Route::get('/customer/orders/{order}/review', [App\Http\Controllers\ReviewController::class, 'showReviewForm'])->name('customer.reviews.create');
    Route::post('/customer/orders/{order}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('customer.reviews.store');
    Route::get('/customer/orders/{order}/review/edit', [App\Http\Controllers\ReviewController::class, 'edit'])->name('customer.reviews.edit');
    Route::put('/customer/orders/{order}/review', [App\Http\Controllers\ReviewController::class, 'update'])->name('customer.reviews.update');
    Route::delete('/customer/orders/{order}/review', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('customer.reviews.destroy');
    Route::get('/technician/{technician}/reviews', [App\Http\Controllers\ReviewController::class, 'technicianReviews'])->name('customer.reviews.technician');
});

// Chat Routes - Technician
Route::middleware(['auth', 'role:technician'])->group(function () {
    Route::get('/technician/chat', [ChatController::class, 'index'])->name('technician.chat.index');
    Route::get('/technician/chat/{order}', [ChatController::class, 'show'])->name('technician.chat.show');
    Route::post('/technician/chat/{order}/send', [ChatController::class, 'sendMessage'])->name('technician.chat.send');
    Route::get('/technician/chat/{order}/messages', [ChatController::class, 'getNewMessages'])->name('technician.chat.messages');
    Route::post('/technician/chat/{order}/read', [ChatController::class, 'markAsRead'])->name('technician.chat.read');
    Route::get('/technician/chat/message/{message}/download', [ChatController::class, 'downloadFile'])->name('technician.chat.download');
    Route::delete('/technician/chat/message/{message}', [ChatController::class, 'deleteMessage'])->name('technician.chat.delete');
    Route::delete('/technician/chat/{order}', [ChatController::class, 'deleteChat'])->name('technician.chat.delete-all');
    Route::get('/technician/chat/notification-count', [ChatController::class, 'getTechnicianNotificationCount'])->name('technician.chat.notification-count');
});

// Test route for debugging
Route::get('/test-mark-all-read', function() {
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Not authenticated']);
    }
    
    $unreadCount = $user->unreadNotifications->count();
    return response()->json([
        'user_id' => $user->id,
        'unread_count' => $unreadCount,
        'notifications' => $user->unreadNotifications->take(5)->get()->map(function($n) {
            return [
                'id' => $n->id,
                'type' => $n->type,
                'data' => $n->data,
                'read_at' => $n->read_at
            ];
        })
    ]);
})->middleware('auth');

// Admin Orders Management
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/orders', [App\Http\Controllers\AdminController::class, 'orders'])->name('admin.orders.index');
});


