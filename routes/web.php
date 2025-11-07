<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\{
    ProfileController,
    ProductController,
    ReviewController,
    FavoriteController,
    UserController,
    CartController,
    WebController,
    CheckoutController,
    ReservationController,
    StoreController
};

Route::get('/', [WebController::class, 'index'])->name('top');

// ======================
// 🔹 店舗関連（一般ユーザー用）
// ======================
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{id}', [StoreController::class, 'show'])->name('stores.show');


require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

    // ======================
    // 商品・レビュー・お気に入り
    // ======================
   Route::resource('products', ProductController::class);
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('favorites/{product_id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('favorites/{product_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // ======================
    // マイページ関連
    // ======================
    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('mypage');
        Route::get('users/mypage/edit', 'edit')->name('mypage.edit');
        Route::put('users/mypage', 'update')->name('mypage.update');
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
        Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
        Route::delete('users/mypage/delete', 'destroy')->name('mypage.destroy');
        Route::get('users/mypage/cart_history', 'cart_history_index')->name('mypage.cart_history');
        Route::get('users/mypage/cart_history/{num}', 'cart_history_show')->name('mypage.cart_history_show');
    });

    // ======================
    // カート・決済
    // ======================
    Route::controller(CartController::class)->group(function () {
        Route::get('users/carts', 'index')->name('carts.index');
        Route::post('users/carts', 'store')->name('carts.store');
        Route::delete('users/carts', 'destroy')->name('carts.destroy');
    });

    Route::controller(CheckoutController::class)->group(function () {
        Route::get('checkout', 'index')->name('checkout.index');
        Route::post('checkout', 'store')->name('checkout.store');
        Route::get('checkout/success', 'success')->name('checkout.success');
    });

    // ======================
    // 🔹 予約関連（ここを1つのブロックにまとめる）
    // ======================
    Route::controller(ReservationController::class)->group(function () {
        Route::get('reservations', 'index')->name('reservations.index');
        Route::delete('reservations/{id}', 'destroy')->name('reservations.destroy');
    });

    Route::get('/stores/{id}/reserve', [ReservationController::class, 'create'])->name('stores.reserve_form');
    Route::post('/stores/{id}/reserve', [ReservationController::class, 'store'])->name('stores.reserve');

  


});