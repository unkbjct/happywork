<?php

use App\Http\Controllers\Admin\Get\CategoriesController as AdminCategoriesViews;
use App\Http\Controllers\Admin\Get\ProductsController as AdminProductsViews;
use App\Http\Controllers\Admin\Post\CategoriesController as AdminCategoriesCore;
use App\Http\Controllers\Admin\Post\ProductsController as AdminProductsCore;
use App\Http\Controllers\Catalog\Get\CatalogController as CatalogViews;
use App\Http\Controllers\Catalog\Post\CatalogController as CatalogCore;
use App\Http\Controllers\User\Get\UserController as UserViews;
use App\Http\Controllers\User\Post\UserController as UserCore;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::group(['prefix' => 'user'], function () {
    Route::get('/signup', [UserViews::class, 'signup'])->name('user.signup');
    Route::get('/login', [UserViews::class, 'login'])->name('user.login');
    Route::get('/profile', [UserViews::class, 'profile'])->name('user.profile');
    Route::get('/favorite', [UserViews::class, 'favorite'])->name('user.favorite');
    Route::get('/history', [UserViews::class, 'history'])->name('user.history');
    Route::get('/logout', [UserViews::class, 'logout'])->name('user.logout');
});

Route::group(['prefix' => 'catalog'], function () {
    Route::get('/', [CatalogViews::class, 'catalog'])->name('catalog');
    Route::get('/{title_eng?}', [CatalogViews::class, 'catalog'])->name('catalog.search');
});

Route::get('/product/{title_eng}', [CatalogViews::class, 'product'])->name('catalog.product');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.products.list');
    })->name('admin');

    Route::get('/products', [AdminProductsViews::class, 'list'])->name('admin.products.list');
    Route::get('/products/create', [AdminProductsViews::class, 'create'])->name('admin.products.create');
    Route::get('/products/{product}/edit', [AdminProductsViews::class, 'edit'])->name('admin.products.edit');

    Route::get('/categories', [AdminCategoriesViews::class, 'list'])->name('admin.categories.list');
    Route::get('/categories/create', [AdminCategoriesViews::class, 'create'])->name('admin.categories.create');
    Route::get('/categories/{category}/edit', [AdminCategoriesViews::class, 'edit'])->name('admin.categories.edit');
});


Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::post('/create', [UserCore::class, 'create'])->name('api.user.create');
        Route::post('/login', [UserCore::class, 'login'])->name('api.user.login');
        Route::post('/edit/personal', [UserCore::class, 'editPersonal'])->name('api.user.edit.personal');
        Route::post('/edit/address', [UserCore::class, 'editAddress'])->name('api.user.edit.address');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::post('/products/create', [AdminProductsCore::class, 'create'])->name('api.admin.products.create');
        Route::post('/products/{product}/edit', [AdminProductsCore::class, 'edit'])->name('api.admin.products.edit');
        Route::post('/products/{product}/remove', [AdminProductsCore::class, 'remove'])->name('api.admin.products.remove');

        Route::post('/categories/create', [AdminCategoriesCore::class, 'create'])->name('api.admin.categories.create');
        Route::post('/categories/{category}/edit', [AdminCategoriesCore::class, 'edit'])->name('api.admin.categories.edit');
        Route::post('/categories/{category}/remove', [AdminCategoriesCore::class, 'remove'])->name('api.admin.categories.remove');
    });

    Route::group(['prefix' => 'catalog'], function () {
        Route::post('/watched', [CatalogCore::class, 'watched'])->name('api.catalog.watched');
        Route::post('/{product}/review', [CatalogCore::class, 'review'])->name('api.catalog.product.review');
    });
});
