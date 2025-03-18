<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/home', function () {
    return view('home');
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
Route::get('/', function () {
    return view('home');
});


// admin routes
Route::get('/admin-dashboard', function () {
    return view('admin.index');
});



// technician routes
Route::get('/tech-dashboard', function () {
    return view('technician.index');
});