<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [testController::class, 'calculate']);
Route::get('/test2', [testController::class, 'getSessionValue'])->name('test-session');