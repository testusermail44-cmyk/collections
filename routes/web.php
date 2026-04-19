<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Collection\CollectionController;
use App\Http\Controllers\Collection\ItemController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Models\Collection;
use App\Models\Category;

Route::get('/', function () {
    $categories = Category::all();
    $latestCollections = Collection::where('is_public', true)->latest()->take(4)->get();
    return view('index', compact('categories', 'latestCollections'));
});
Route::get('/home', function() {
    $categories = Category::all();
    $latestCollections = Collection::where('is_public', true)->latest()->take(4)->get();
    return view('index', compact('categories', 'latestCollections'));
});
Route::get('/auth/login', function() {
    return view('/auth/login');
});
Route::post('/auth/login', [LoginController::class, 'auth']);
Route::get('/auth/registration', function() {
    return view('/auth/registration');
});
Route::post('/auth/registration', [RegistrationController::class, 'register']);
Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create')->middleware('auth');
Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store')->middleware('auth');
Route::get('/collections/{collection}/items/create', function($collection){
    $col = Collection::findOrFail($collection);
    return view('/collections/itemEditor', [
        'collection' => $col]);
})->name('items.create')->middleware('auth');
Route::post('/collections/{collection}/items', [ItemController::class, 'store'])->name('items.store')->middleware('auth');
Route::post('/logout', function (Request $request) {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
Route::get('/collections/collections', [CollectionController::class, 'index'])->name('collections.show');
Route::get('/collections/{collection}/collection', [CollectionController::class, 'show'])->name('collections.elements');
Route::get('/collections/{collection}/collection/my', [CollectionController::class, 'show'])->name('collections.elements.my')->middleware('auth');
Route::get('/collections/{item}/item', [CollectionController::class, 'showItem'])->name('collection.item');
Route::post('/items/{item}/comment', [CollectionController::class, 'storeComment'])->name('items.comment')->middleware('auth');
Route::delete('/comments/{comment}', [CollectionController::class, 'destroyComment'])->name('comments.destroy')->middleware('auth');
Route::get('/collections/collections/my', [CollectionController::class, 'index'])->name('collections.my')->middleware('auth');
Route::get('/collections/{collection}/edit', [CollectionController::class, 'edit'])->name('collections.edit')->middleware('auth');
Route::put('/collections/{collection}', [CollectionController::class, 'update'])->name('collections.update')->middleware('auth');
Route::delete('/collections/{collection}', [CollectionController::class, 'destroy'])->name('collections.destroy')->middleware('auth');
Route::get('/user/settings', [ProfileController::class, 'edit'])->name('user.edit')->middleware('auth');
Route::put('/user/settings', [ProfileController::class, 'update'])->name('user.update')->middleware('auth');
Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit')->middleware('auth');
Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update')->middleware('auth');
Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy')->middleware('auth');
Route::delete('/items/photo/{image}', [ItemController::class, 'destroyImage'])->name('items.photo.destroy')->middleware('auth');
Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users.index')->middleware('auth');
Route::patch('/admin/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('admin.users.toggle')->middleware('auth');
Route::get('/admin/categories', [AdminController::class, 'categoriesIndex'])->name('admin.categories.index')->middleware('auth');
Route::get('/admin/categories/create', [AdminController::class, 'categoryCreate'])->name('admin.categories.create')->middleware('auth');
Route::get('/admin/categories/{category}/edit', [AdminController::class, 'categoryEdit'])->name('admin.categories.edit')->middleware('auth');
Route::post('/admin/categories', [AdminController::class, 'categoryStore'])->name('admin.categories.store')->middleware('auth');
Route::put('/admin/categories/{category}', [AdminController::class, 'categoryUpdate'])->name('admin.categories.update')->middleware('auth');
Route::delete('/admin/categories/{category}', [AdminController::class, 'categoryDestroy'])->name('admin.categories.destroy')->middleware('auth');
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


Route::get('/debug-user', function () {
    dd(auth()->user());  
});

Route::get('/test', [testController::class, 'calculate']);
Route::post('/test/upload', [testController::class, 'upload'])->name('test-upload'); // Новий роут
Route::get('/test2', [testController::class, 'getSessionValue'])->name('test-session');