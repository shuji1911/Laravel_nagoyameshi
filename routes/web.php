<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;

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

// トップページ
Route::get('/', function () {
    return view('welcome');
});

// 認証ルート
require __DIR__.'/auth.php';

// 管理者ルートグループ
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    // ホームページ
    Route::get('home', [HomeController::class, 'index'])->name('home');
    
    // 会員一覧ページ
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    
    // 会員詳細ページ
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    
    // 店舗一覧ページ
    Route::get('restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');

    // 店舗詳細ページ
    Route::get('restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

    // 店舗登録ページ
    Route::get('restaurants', [RestaurantController::class, 'create'])->name('restaurants.create');

    // 店舗登録機能
    Route::post('restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');

    // 店舗編集ページ
    Route::get('restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');

    // 店舗更新機能
    Route::put('restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');

    // 店舗削除機能
    Route::delete('restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');

    // カテゴリ一覧ページ
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');

    // カテゴリ登録ページ（表示）
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    
    // カテゴリ登録機能（実行）
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    
    // カテゴリ編集ページ（表示）
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    
    // カテゴリ更新機能（実行）
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    
    // カテゴリ削除機能（実行）
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

