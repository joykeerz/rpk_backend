<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GudangController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoryController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\CustomerController;

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

Route::middleware(['auth'])->group(function () {

    ///Manage
    Route::prefix('manage')->middleware('restrictRole:1')->group(function () {
        ///user
        Route::get('/', [ManageUserController::class, 'index'])->name('manage.user.index');

        Route::middleware('restrictRole:1')->group(function () {
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
    Route::prefix('gudang')->group(function () {
        Route::get('/', [GudangController::class, 'index'])->name('gudang.index');
        Route::post('/store', [GudangController::class, 'store'])->name('gudang.store');
        Route::get('/show/{id}', [GudangController::class, 'show'])->name('gudang.show');
        Route::post('/update/{id}', [GudangController::class, 'update'])->name('gudang.update');
        Route::get('/delete/{id}', [GudangController::class, 'delete'])->name('gudang.delete');
        Route::get('/create', [GudangController::class, 'create'])->name('gudang.create');
    });

    ///company (Kanwil)
    Route::prefix('company')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('company.index');
        Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
        Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
        Route::get('/show/{id}', [CompanyController::class, 'show'])->name('company.show');
        Route::post('/update/{id}', [CompanyController::class, 'update'])->name('company.update');
        Route::get('/delete/{id}', [CompanyController::class, 'delete'])->name('company.delete');
    });

    ///stok
    Route::prefix('stok')->group(function () {
        Route::post('/update/product/stok/{id}', [StokController::class, 'updateFromProduct'])->name('stok.updateFromProduct');
        Route::post('/update/product/restock/{id}', [StokController::class, 'increaseStock'])->name('stok.increase');
    });

    ///branch (KC,KCP)
    Route::prefix('branch')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('branch.index');
        Route::get('/manage', [BranchController::class, 'manage'])->name('branch.manage');
        Route::post('/store', [BranchController::class, 'store'])->name('branch.store');
        Route::get('/create', [BranchController::class, 'create'])->name('branch.create');
        Route::get('/show/{id}', [BranchController::class, 'show'])->name('branch.show');
        Route::post('/update/{id}', [BranchController::class, 'update'])->name('branch.update');
        Route::get('/delete/{id}', [BranchController::class, 'delete'])->name('branch.delete');
    });

    ///pesanan
    Route::prefix('pesanan')->group(function () {
        Route::get('/', [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('/show/{id}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::get('/newOrder', [PesananController::class, 'newOrder'])->name('pesanan.newOrder');
        Route::post('/storeOrder', [PesananController::class, 'storeOrder'])->name('pesanan.storeOrder');
        Route::get('/newTransaksi/{id}', [PesananController::class, 'newTransaksi'])->name('pesanan.newTransaksi');
        Route::post('/storeTransaksi', [PesananController::class, 'storeTransaksi'])->name('pesanan.storeTransaksi');
    });

    ///customer
    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/show/{id}', [CustomerController::class, 'show'])->name('customer.show');
        Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
    });
});
