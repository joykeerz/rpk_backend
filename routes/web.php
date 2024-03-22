<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BeritaController;
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
use App\Http\Controllers\DaftarAlamatController;
use App\Http\Controllers\EtalaseController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Odoo\BranchController as OdooBranchController;
use App\Http\Controllers\Odoo\CategoryController;
use App\Http\Controllers\Odoo\CompanyController as OdooCompanyController;
use App\Http\Controllers\Odoo\GudangController as OdooGudangController;
use App\Http\Controllers\Odoo\LocationController as OdooLocationController;
use App\Http\Controllers\Odoo\PriceController;
use App\Http\Controllers\Odoo\ProductController as OdooProductController;
use App\Http\Controllers\Odoo\SatuanUnitController as OdooSatuanUnitController;
use App\Http\Controllers\Odoo\StockController;
use App\Http\Controllers\Odoo\SynchronizeController;
use App\Http\Controllers\Odoo\UserController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\PriceController as ControllersPriceController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\SatuanUnitController;
use App\Livewire\DatasTable;
use App\Livewire\Etalase\EtalaseIndex;

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


Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('odoo')->group(function () {
    Route::prefix('sync')->group(function () {
        Route::get('/import', [SynchronizeController::class, 'synchronizeAll'])->name('odoo.sync.import');
        Route::get('/debug', [SynchronizeController::class, 'syncDebug'])->name('odoo.sync.debug');
    });
    Route::prefix('product')->group(function () {
        Route::get('/import', [OdooProductController::class, 'importFromErp'])->name('odoo.product.import');
    });
    Route::prefix('category')->group(function () {
        Route::get('/import', [CategoryController::class, 'importFromErp'])->name('odoo.category.import');
    });
    Route::prefix('user')->group(function () {
        Route::get('/import/manager-sales', [UserController::class, 'importManagerSalesUsers'])->name('odoo.user.import.manager-sales');
        Route::get('/import/customer', [UserController::class, 'importCustomerUsers'])->name('odoo.user.import.customer');
        Route::get('/import/partner', [UserController::class, 'importPartnerUsers'])->name('odoo.user.import.partner');
    });
    Route::prefix('satuan-unit')->group(function () {
        Route::get('/import', [OdooSatuanUnitController::class, 'importFromErp'])->name('odoo.satuan-unit.import');
    });
    Route::prefix('company')->group(function () {
        Route::get('/import', [OdooCompanyController::class, 'importFromErp'])->name('odoo.company.import');
    });
    Route::prefix('gudang')->group(function () {
        Route::get('/import', [OdooGudangController::class, 'importFromErp'])->name('odoo.gudang.import');
    });
    Route::prefix('branch')->group(function () {
        Route::get('/import', [OdooBranchController::class, 'importFromErp'])->name('odoo.branch.import');
    });
    Route::prefix('stock')->group(function () {
        Route::get('/import', [StockController::class, 'importStock'])->name('odoo.stock.import');
    });
    Route::prefix('price')->group(function () {
        Route::get('/import', [PriceController::class, 'importPrice'])->name('odoo.price.import');
    });
    Route::prefix('location')->group(function () {
        Route::get('/import', [OdooLocationController::class, 'importLocation'])->name('odoo.location.import');
    });
});

Route::middleware(['auth'])->group(function () {

    ///Manage
    Route::prefix('manage')->group(function () {
        ///user
        Route::get('/', [ManageUserController::class, 'index'])->middleware('restrictRole:2,3,4')->name('manage.user.index');
        Route::middleware('restrictRole:2,4')->group(function () {
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
    Route::prefix('product')->middleware('restrictRole:2,3')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/manage', [ProductController::class, 'manage'])->name('product.manage');
        Route::get('/search', [ProductController::class, 'searchProduct'])->name('product.search');
    });

    ///Category
    Route::prefix('category')->middleware('restrictRole:2,3')->group(function () {
        Route::get('/', [KategoryController::class, 'index'])->name('category.index');
        Route::post('/store', [KategoryController::class, 'store'])->name('category.store');
        Route::get('/show/{id}', [KategoryController::class, 'show'])->name('category.show');
        Route::post('/update/{id}', [KategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [KategoryController::class, 'delete'])->name('category.delete');
    });

    ///Gudang
    Route::prefix('gudang')->middleware('restrictRole:2')->group(function () {
        Route::get('/', [GudangController::class, 'index'])->name('gudang.index');
        Route::post('/store', [GudangController::class, 'store'])->name('gudang.store');
        Route::get('/show/{id}', [GudangController::class, 'show'])->name('gudang.show');
        Route::post('/update/{id}', [GudangController::class, 'update'])->name('gudang.update');
        Route::get('/delete/{id}', [GudangController::class, 'delete'])->name('gudang.delete');
        Route::get('/create', [GudangController::class, 'create'])->name('gudang.create');
    });

    ///company (Kanwil)
    Route::prefix('company')->middleware('restrictRole:2')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('company.index');
        Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
        Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
        Route::get('/show/{id}', [CompanyController::class, 'show'])->name('company.show');
        Route::post('/update/{id}', [CompanyController::class, 'update'])->name('company.update');
        Route::get('/delete/{id}', [CompanyController::class, 'delete'])->name('company.delete');
    });

    ///stok
    Route::prefix('stok')->middleware('restrictRole:4')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('stok.index');
        Route::get('/all', [StokController::class, 'showAll'])->name('stok.showAll');
        Route::get('/show/gudang/{id}', [StokController::class, 'stockByGudang'])->name('stok.show');
        Route::get('/delete/{id}', [StokController::class, 'delete'])->name('stok.delete');
        Route::get('/create/gudang/{id}', [StokController::class, 'createStock'])->name('stok.create');
        Route::post('/create/gudang/{id}', [StokController::class, 'insertStock'])->name('stok.insert');
        Route::get('/show/detail/{id}', [StokController::class, 'showStock'])->name('stok.detail');
        Route::post('/show/detail/{id}', [StokController::class, 'updateStock'])->name('stok.update');
        Route::post('/increase/{id}', [StokController::class, 'increaseStock'])->name('stok.increase');
    });

    ///branch (KC,KCP)
    Route::prefix('branch')->middleware('restrictRole:2')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('branch.index');
        Route::get('/manage', [BranchController::class, 'manage'])->name('branch.manage');
        Route::post('/store', [BranchController::class, 'store'])->name('branch.store');
        Route::get('/create', [BranchController::class, 'create'])->name('branch.create');
        Route::get('/show/{id}', [BranchController::class, 'show'])->name('branch.show');
        Route::post('/update/{id}', [BranchController::class, 'update'])->name('branch.update');
        Route::get('/delete/{id}', [BranchController::class, 'delete'])->name('branch.delete');
    });

    ///pesanan
    Route::prefix('pesanan')->middleware('restrictRole:2,3,4')->group(function () {
        Route::get('/transaksi/gudang/{id}', [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('/show/{id}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::get('/order/gudang', [PesananController::class, 'orderByGudangSelector'])->name('pesanan.selectGudang');
        Route::get('/transaksi/gudang', [PesananController::class, 'transaksiByGudangSelector'])->name('pesanan.selectTransaksi');
        Route::get('/newOrder/gudang/{id}', [PesananController::class, 'newOrder'])->name('pesanan.newOrder');
        Route::post('/storeOrder', [PesananController::class, 'storeOrder'])->name('pesanan.storeOrder');
        Route::get('/newTransaksi/{id}', [PesananController::class, 'newTransaksi'])->name('pesanan.newTransaksi');
        Route::post('/storeTransaksi', [PesananController::class, 'storeTransaksi'])->name('pesanan.storeTransaksi');
        Route::get('/edit/{id}', [PesananController::class, 'edit'])->name('pesanan.edit');
        Route::post('/update/{id}', [PesananController::class, 'update'])->name('pesanan.update');
        Route::get('/verify/{id}', [PesananController::class, 'verify'])->name('pesanan.verify');
    });

    ///customer
    Route::prefix('customer')->middleware('restrictRole:2,3,4')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/show/{id}', [CustomerController::class, 'show'])->name('customer.show');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
        Route::get('/verify/{id}', [CustomerController::class, 'verify'])->name('customer.verify');
        Route::get('/reject/{id}', [CustomerController::class, 'reject'])->name('customer.reject');
    });

    ///Daftar Alamat
    Route::prefix('daftar-alamat')->middleware('restrictRole:2,3,4')->group(function () {
        Route::get('/customer/{id}', [DaftarAlamatController::class, 'index'])->name('daftar-alamat.customer.index');
        Route::get('/customer/create/{id}', [DaftarAlamatController::class, 'create'])->name('daftar-alamat.customer.create');
        Route::post('/customer/insert/{id}', [DaftarAlamatController::class, 'insert'])->name('daftar-alamat.customer.insert');
        Route::get('/customer/detail/{id}', [DaftarAlamatController::class, 'show'])->name('daftar-alamat.customer.show');
        Route::put('/customer/update/{id}', [DaftarAlamatController::class, 'update'])->name('daftar-alamat.customer.update');
        Route::get('/customer/delete/{id}', [DaftarAlamatController::class, 'delete'])->name('daftar-alamat.customer.delete');
        Route::get('/customer/toggle/{id}', [DaftarAlamatController::class, 'toggle'])->name('daftar-alamat.customer.toggle');
    });

    ///reporting (Laporan) route
    Route::prefix('laporan')->middleware('restrictRole:3,2')->group(function () {
        Route::get('/', [ReportingController::class, 'index'])->name('laporan.index');
        Route::get('/stok', [ReportingController::class, 'reportStockAll'])->name('laporan.stock');
        Route::get('/penjualan', [ReportingController::class, 'reportPenjualan'])->name('laporan.penjualan');
        Route::get('/laporan/stok/export', [ReportingController::class, 'exportStok'])->name('laporan.stok.export');
        Route::get('/laporan/penjualan/export', [ReportingController::class, 'exportPenjualan'])->name('laporan.penjualan.export');
    });

    ///Banner Route
    Route::prefix('banner')->middleware('restrictRole:2,3,4')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('banner.index');
        Route::get('/create', [BannerController::class, 'create'])->name('banner.create');
        Route::post('/store', [BannerController::class, 'store'])->name('banner.store');
        Route::get('/show/{id}', [BannerController::class, 'show'])->name('banner.show');
        Route::post('/update/{id}', [BannerController::class, 'update'])->name('banner.update');
        Route::get('/delete/{id}', [BannerController::class, 'delete'])->name('banner.delete');
    });

    ///Berita Route
    Route::prefix('berita')->middleware('restrictRole:2,3,4')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
        Route::get('/create', [BeritaController::class, 'create'])->name('berita.create');
        Route::post('/store', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('/show/{id}', [BeritaController::class, 'show'])->name('berita.show');
        Route::post('/update/{id}', [BeritaController::class, 'update'])->name('berita.update');
        Route::get('/delete/{id}', [BeritaController::class, 'delete'])->name('berita.delete');
    });

    ///Pajak Route
    Route::prefix('pajak')->middleware('restrictRole:2,3,4')->group(function () {
        Route::get('/', [PajakController::class, 'index'])->name('pajak.index');
        Route::get('/create', [PajakController::class, 'create'])->name('pajak.create');
        Route::post('/store', [PajakController::class, 'store'])->name('pajak.store');
        Route::get('/show/{id}', [PajakController::class, 'show'])->name('pajak.show');
        Route::post('/update/{id}', [PajakController::class, 'update'])->name('pajak.update');
        Route::get('/delete/{id}', [PajakController::class, 'destroy'])->name('pajak.delete');
    });

    ///satuan unit route
    Route::prefix('satuan-unit')->middleware('restrictRole:2,3,4')->group(function () {
        Route::get('/', [SatuanUnitController::class, 'index'])->name('satuan-unit.index');
        Route::get('/create', [SatuanUnitController::class, 'create'])->name('satuan-unit.create');
        Route::post('/store', [SatuanUnitController::class, 'store'])->name('satuan-unit.store');
        Route::get('/show/{id}', [SatuanUnitController::class, 'show'])->name('satuan-unit.show');
        Route::post('/update/{id}', [SatuanUnitController::class, 'update'])->name('satuan-unit.update');
        Route::get('/delete/{id}', [SatuanUnitController::class, 'destroy'])->name('satuan-unit.delete');
    });

    ///Location route
    Route::prefix('gudang/location')->middleware('restrictRole:2,3,4')->group(function () {
        Route::get('/list/{id}', [LocationController::class, 'index'])->name('location.index');
        Route::get('/create/{id}', [LocationController::class, 'create'])->name('location.create');
        Route::post('/store', [LocationController::class, 'store'])->name('location.store');
        Route::get('/show/{id}', [LocationController::class, 'show'])->name('location.show');
        Route::post('/update/{id}', [LocationController::class, 'update'])->name('location.update');
        Route::get('/delete/{id}', [LocationController::class, 'destroy'])->name('location.delete');
        Route::post('/activate/{id}', [LocationController::class, 'activateLocation'])->name('location.activate');
    });

    Route::prefix('prices')->middleware('restrictRole:4')->group(function () {
        Route::get('/', [ControllersPriceController::class, 'index'])->name('prices.index');
        Route::post('/store', [ControllersPriceController::class, 'store'])->name('prices.store');
        Route::get('/show/{id}', [ControllersPriceController::class, 'show'])->name('prices.show');
        Route::post('/update/{id}', [ControllersPriceController::class, 'update'])->name('prices.update');
        Route::get('/delete/{id}', [ControllersPriceController::class, 'destroy'])->name('prices.delete');
    });

    Route::prefix('etalase')->middleware('restrictRole:4')->group(function () {
        // Route::get('/', EtalaseIndex::class)->name('etalase.index');
        Route::get('/', DatasTable::class)->name('etalase.index');
    });
});
