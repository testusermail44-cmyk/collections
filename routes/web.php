<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\registrationController;

Route::get('/', function () {
    return view('index');
});
Route::get('/home', function() {
    return view('index');
});
Route::get('/auth/login', function() {
    return view('/auth/login');
});
Route::post('/auth/login', [loginController::class, 'auth']);
Route::get('/auth/registration', function() {
    return view('/auth/registration');
});
Route::post('/auth/registration', [registrationController::class, 'register']);
Route::get('', function(){
    return view('');
});

Route::get('/debug-user', function () {
    dd(auth()->user());  
});

Route::get('/test', [testController::class, 'calculate']);
Route::post('/test/upload', [testController::class, 'upload'])->name('test-upload'); // Новий роут
Route::get('/test2', [testController::class, 'getSessionValue'])->name('test-session');