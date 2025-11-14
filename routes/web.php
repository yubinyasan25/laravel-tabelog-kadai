<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    WebController,
    StoreController,
    UserController,
    CartController,
    CheckoutController,
    ReservationController,
    ReviewController,
    FavoriteController,
    MypageController,
    PaidMemberController
};

// ======================
// トップページ
// ======================
Route::get('/', [WebController::class, 'index'])->name('top');

// ======================
// 店舗（一般ユーザー用）
// ======================
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{id}', [StoreController::class, 'show'])->name('stores.show');

// ======================
// 認証ルート
// ======================
require __DIR__.'/auth.php';

// ======================
// 認証・メール認証済みユーザー用
// ======================
Route::middleware(['auth', 'verified'])->group(function () {

    // ======================
    // マイページ（一般）
    // ======================
    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('users.mypage');
        Route::get('users/mypage/edit', 'edit')->name('users.mypage.edit');
        Route::put('users/mypage', 'update')->name('users.mypage.update');
        Route::get('users/mypage/password/edit', 'edit_password')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'update_password')->name('mypage.update_password');
        Route::get('users/mypage/favorite', 'favorite')->name('mypage.favorite');
        Route::delete('users/mypage/delete', 'destroy')->name('users.mypage.destroy');
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
    // 予約管理
    // ======================
    Route::controller(ReservationController::class)->group(function () {
        Route::get('reservations', 'index')->name('reservations.index');
        Route::delete('reservations/{id}', 'destroy')->name('reservations.destroy');
    });

    // ======================
    // 有料会員限定機能
    // ======================
    Route::middleware(['paid'])->group(function () {

        // 予約
        Route::get('/stores/{id}/reserve', [ReservationController::class, 'create'])->name('stores.reserve_form');
        Route::post('/stores/{id}/reserve', [ReservationController::class, 'store'])->name('stores.reserve');

        // レビュー投稿・編集・削除
        Route::post('/stores/{store}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        // お気に入り関連
        Route::post('/stores/{store}/favorite', [FavoriteController::class, 'toggle'])->name('stores.favorite.toggle');
        Route::post('/stores/{store}/favorite/add', [FavoriteController::class, 'store'])->name('stores.favorite.store');
        Route::delete('/stores/{store}/favorite/remove', [FavoriteController::class, 'destroy'])->name('stores.favorite.destroy');
        Route::get('/mypage/favorite-stores', [FavoriteController::class, 'index'])->name('mypage.favorite_stores');
    });

    // ======================
    // 有料会員登録関連（PaidMemberController）
    // ======================
    Route::get('/paid/register', [PaidMemberController::class, 'showForm'])->name('paid.register');
    Route::post('/paid/register', [PaidMemberController::class, 'store'])->name('paid.store');
    Route::post('/paid/card/update', [PaidMemberController::class, 'updateCard'])->name('paid.updateCard');
    Route::post('/paid/cancel', [PaidMemberController::class, 'cancel'])->name('paid.cancel');

});
