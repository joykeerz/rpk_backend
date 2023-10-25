<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
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

    ///Product
    Route::prefix('product')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::get('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    });

    ///Category
    Route::prefix('category')->group(function(){
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::get('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    });

    ///SubCategory
    Route::prefix('subcat')->group(function(){
        Route::get('/', [SubcatController::class, 'index'])->name('subcat.index');
        Route::get('/store', [SubcatController::class, 'store'])->name('subcat.store');
        Route::get('/edit/{id}', [SubcatController::class, 'edit'])->name('subcat.edit');
        Route::get('/update/{id}', [SubcatController::class, 'update'])->name('subcat.update');
        Route::get('/delete/{id}', [SubcatController::class, 'delete'])->name('subcat.delete');
    });

});
