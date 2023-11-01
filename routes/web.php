<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoryController;
use App\Http\Controllers\ManageUserController;

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

Route::get("/inventory", [App\Http\Controllers\InventoryController::class, 'index']);
Route::get("/inputBarang", [App\Http\Controllers\InputBarangController::class, 'index']);
Route::get('store', [ProductController::class, 'store']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function(){

    ///Manage
    Route::prefix('manage')->group(function(){

        ///user
        Route::get('/', [ManageUserController::class, 'index'])->name('manage.user.index');
        Route::get('/user/new', [ManageUserController::class, 'newUser'])->name('manage.user.new');
        Route::post('/user/store', [ManageUserController::class, 'StoreNewAccount'])->name('manage.user.store');
        Route::get('/user/verify/{id}', [ManageUserController::class, 'verify'])->name('manage.user.verify');
        Route::get('/user/reject/{id}', [ManageUserController::class, 'reject'])->name('manage.user.reject');
        Route::get('/user/edit/{id}', [ManageUserController::class, 'edit'])->name('manage.user.edit');
        Route::post('/user/update/{id}', [ManageUserController::class, 'update'])->name('manage.user.update');
        Route::post('/user/update/alamat/{id}', [ManageUserController::class, 'changeAlamat'])->name('manage.user.update.alamat');
        Route::post('/user/update/password/{id}', [ManageUserController::class, 'changePassword'])->name('manage.user.changePassword');
        Route::get('/user/delete', [ManageUserController::class, 'delete'])->name('manage.user.delete');
        Route::post('/user/store/{id}/biodata', [ManageUserController::class, 'storeBiodata'])->name('manage.user.storeBiodata');
        Route::post('/user/store/{id}/alamat', [ManageUserController::class, 'storeAlamat'])->name('manage.user.storeAlamat');
        Route::post('/user/store/new', [ManageUserController::class, 'StoreNewAccount'])->name('manage.user.StoreNewAccount');

    });

    ///Product
    Route::prefix('product')->group(function(){
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/manage', [ProductController::class, 'manage'])->name('product.manage');
    });

    ///Category
    Route::prefix('category')->group(function(){
        Route::get('/', [KategoryController::class, 'index'])->name('category.index');
        Route::post('/store', [KategoryController::class, 'store'])->name('category.store');
        Route::get('/show/{id}', [KategoryController::class, 'show'])->name('category.show');
        Route::post('/update/{id}', [KategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [KategoryController::class, 'delete'])->name('category.delete');
    });

});
