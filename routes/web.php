<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoryController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\SubcatController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function(){

    ///Manage
    Route::prefix('manage')->group(function(){

        ///user
        Route::get('/', [ManageUserController::class, 'index'])->name('manage.user.index');
        Route::post('/user/store', [ManageUserController::class, 'store'])->name('manage.user.store');
        Route::post('/user/verify/{id}', [ManageUserController::class, 'verify'])->name('manage.user.verify');
        Route::post('/user/reject/{id}', [ManageUserController::class, 'reject'])->name('manage.user.reject');
        Route::get('/user/edit/{id}', [ManageUserController::class, 'edit'])->name('manage.user.edit');
        Route::post('/user/update/{id}', [ManageUserController::class, 'update'])->name('manage.user.update');
        Route::post('/user/update/password/{id}', [ManageUserController::class, 'changePassword'])->name('manage.user.changePassword');
        Route::get('/user/delete', [ManageUserController::class, 'delete'])->name('manage.user.delete');

    });

    ///Product
    Route::prefix('product')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    });

    ///Category
    Route::prefix('category')->group(function(){
        Route::get('/', [KategoryController::class, 'index'])->name('category.index');
        Route::post('/store', [KategoryController::class, 'store'])->name('category.store');
        Route::get('/edit/{id}', [KategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [KategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [KategoryController::class, 'delete'])->name('category.delete');
    });

    ///SubCategory
    Route::prefix('subcat')->group(function(){
        Route::get('/', [SubcatController::class, 'index'])->name('subcat.index');
        Route::post('/store', [SubcatController::class, 'store'])->name('subcat.store');
        Route::get('/edit/{id}', [SubcatController::class, 'edit'])->name('subcat.edit');
        Route::post('/update/{id}', [SubcatController::class, 'update'])->name('subcat.update');
        Route::get('/delete/{id}', [SubcatController::class, 'delete'])->name('subcat.delete');
    });

});
