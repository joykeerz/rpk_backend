<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GudangController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoryController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\StokController;

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


Route::middleware(['auth'])->group(function () {

    ///Manage
    Route::prefix('manage')->group(function () {
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
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/manage', [ProductController::class, 'manage'])->name('product.manage');
        Route::get('/search', [ProductController::class, 'searchProduct'])->name('product.search');
    });

    ///Category
    Route::prefix('category')->group(function () {
        Route::get('/', [KategoryController::class, 'index'])->name('category.index');
        Route::post('/store', [KategoryController::class, 'store'])->name('category.store');
        Route::get('/show/{id}', [KategoryController::class, 'show'])->name('category.show');
        Route::post('/update/{id}', [KategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [KategoryController::class, 'delete'])->name('category.delete');
    });

    ///Gudang
    Route::prefix('gudang')->group(function(){
        Route::get('/', [GudangController::class, 'index'])->name('gudang.index');
        Route::post('/store', [GudangController::class, 'store'])->name('gudang.store');
        Route::get('/show/{id}', [GudangController::class, 'show'])->name('gudang.show');
        Route::post('/update/{id}', [GudangController::class, 'update'])->name('gudang.update');
        Route::get('/delete/{id}', [GudangController::class, 'delete'])->name('gudang.delete');
        Route::get('/create', [GudangController::class, 'create'])->name('gudang.create');
    });

    ///company
    Route::prefix('company')->group(function(){
        Route::get('/', [CompanyController::class, 'index'])->name('company.index');
        Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
        Route::get('/show/{id}', [CompanyController::class, 'show'])->name('company.show');
        Route::post('/update/{id}', [CompanyController::class, 'update'])->name('company.update');
        Route::get('/delete/{id}', [CompanyController::class, 'delete'])->name('company.delete');
    });

    ///stok
    Route::prefix('stok')->group(function(){
        Route::post('/update/product/stok/{id}', [StokController::class, 'updateFromProduct'])->name('stok.updateFromProduct');
    });
});
