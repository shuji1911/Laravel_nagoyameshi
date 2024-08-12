<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RegularHolidayController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\TermController as AdminTermController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TermController;

// 一般ユーザー用ルート
Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/user/update', [UserController::class, 'update'])->name('user.update');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');

    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
    Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

     // 会社概要と利用規約ページ
     Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
     Route::get('/terms', [TermController::class, 'index'])->name('terms.index');

    

});

// 認証とサブスクリプションのルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['subscribed:premium_plan'])->group(function () {
        // レビュー作成、更新、削除に関するリソースルート
        Route::resource('restaurants.reviews', ReviewController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['reviews' => 'review']);

             // 予約作成、保存、キャンセルに関するルート
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/restaurants/{restaurant}/reservations/create', [ReservationController::class, 'create'])->name('restaurants.reservations.create');
        Route::post('/restaurants/{restaurant}/reservations', [ReservationController::class, 'store'])->name('restaurants.reservations.store');
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

        // お気に入り機能のルート
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favorites/{restaurant_id}', [FavoriteController::class, 'store'])->name('favorites.store');
        Route::delete('/favorites/{restaurant_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    });

    // レビュー一覧ルート
    Route::get('restaurants/{restaurant}/reviews', [ReviewController::class, 'index'])
        ->name('restaurants.reviews.index');
});

    Route::middleware('not_subscribed:premium_plan')->group(function () {
        Route::get('subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
        Route::post('subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
    });

    Route::middleware('subscribed:premium_plan')->group(function () {
        Route::get('subscription/edit', [SubscriptionController::class, 'edit'])->name('subscription.edit');
        Route::put('subscription', [SubscriptionController::class, 'update'])->name('subscription.update');
        Route::get('subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
        Route::delete('subscription', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');
    });


// 認証ルート
require __DIR__.'/auth.php';

// 管理者用ルート
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    Route::get('home', [AdminHomeController::class, 'index'])->name('home');
    
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    
    Route::get('restaurants', [AdminRestaurantController::class, 'index'])->name('restaurants.index');
    Route::get('restaurants/create', [AdminRestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('restaurants', [AdminRestaurantController::class, 'store'])->name('restaurants.store');
    Route::get('restaurants/{restaurant}', [AdminRestaurantController::class, 'show'])->name('restaurants.show');
    Route::get('restaurants/{restaurant}/edit', [AdminRestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::patch('restaurants/{restaurant}', [AdminRestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('restaurants/{restaurant}', [AdminRestaurantController::class, 'destroy'])->name('restaurants.destroy');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    Route::get('regular-holidays', [RegularHolidayController::class, 'index'])->name('regular_holidays.index');
    Route::get('regular-holidays/create', [RegularHolidayController::class, 'create'])->name('regular_holidays.create');
    Route::post('regular-holidays', [RegularHolidayController::class, 'store'])->name('regular_holidays.store');
    Route::get('regular-holidays/{regularHoliday}', [RegularHolidayController::class, 'show'])->name('regular_holidays.show');
    Route::get('regular-holidays/{regularHoliday}/edit', [RegularHolidayController::class, 'edit'])->name('regular_holidays.edit');
    Route::patch('regular-holidays/{regularHoliday}', [RegularHolidayController::class, 'update'])->name('regular_holidays.update');
    Route::delete('regular-holidays/{regularHoliday}', [RegularHolidayController::class, 'destroy'])->name('regular_holidays.destroy');

    Route::get('company', [AdminCompanyController::class, 'index'])->name('company.index');
    Route::get('company/edit', [AdminCompanyController::class, 'edit'])->name('company.edit');
    Route::patch('company', [AdminCompanyController::class, 'update'])->name('company.update');

    Route::get('terms', [AdminTermController::class, 'index'])->name('terms.index');
    Route::get('terms/edit', [AdminTermController::class, 'edit'])->name('terms.edit');
    Route::patch('terms', [AdminTermController::class, 'update'])->name('terms.update');

    
});
