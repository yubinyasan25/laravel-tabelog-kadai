<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    WebController,
    StoreController,
    UserController,
    PaidMemberController,
    CartController,
    CheckoutController,
    ReservationController,
    ReviewController,
    FavoriteController
};

// ----------------------
// トップページ
// ----------------------
Route::get('/', [WebController::class, 'index'])->name('top');

// ----------------------
// 店舗
// ----------------------
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{id}', [StoreController::class, 'show'])->name('stores.show');

// ----------------------
// 認証ルート
// ----------------------
require __DIR__.'/auth.php';

// ----------------------
// 認証・メール認証済みユーザー用
// ----------------------
Route::middleware(['auth', 'verified'])->group(function () {

    // ----------------------
    // ユーザー関連
    // ----------------------
    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('users.mypage');
        Route::get('users/mypage/edit', 'edit')->name('users.mypage.edit');
        Route::put('users/mypage', 'update')->name('users.mypage.update');

        Route::get('users/mypage/password/edit', 'editPassword')->name('mypage.edit_password');
        Route::put('users/mypage/password', 'updatePassword')->name('mypage.update_password');

        Route::delete('users/mypage/delete', 'destroy')->name('users.mypage.destroy');
    });

    // ----------------------
    // 有料会員登録（Stripe Checkout）
    // ----------------------
    Route::get('/paid/register', [PaidMemberController::class, 'showForm'])->name('paid.register');
    Route::post('/paid/checkout', [PaidMemberController::class, 'createCheckoutSession'])->name('paid.session');
    Route::get('/paid/success', [PaidMemberController::class, 'success'])->name('paid.success');
    Route::get('/paid/cancel', [PaidMemberController::class, 'cancelPage'])->name('paid.cancelPage');
    Route::post('/paid/cancel', [PaidMemberController::class, 'cancel'])->name('paid.cancel');

    // ----------------------
    // レビュー関連
    // ----------------------
    Route::controller(ReviewController::class)->group(function () {
        
        Route::post('/stores/{store}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/reviews/{review}/edit', 'edit')->name('reviews.edit');             // レビュー編集画面
        Route::put('/reviews/{review}', 'update')->name('reviews.update');             // レビュー更新
        Route::delete('/reviews/{review}', 'destroy')->name('reviews.destroy');        // レビュー削除
    });

    // ----------------------
    // 予約関連
    // ----------------------
    Route::controller(ReservationController::class)->group(function () {
        Route::get('/reservations', 'index')->name('reservations.index');             // 予約一覧
        Route::post('/stores/{store}/reserve', 'store')->name('stores.reserve');      // 予約作成
        Route::get('/reservations/{reservation}/edit', 'edit')->name('reservations.edit');      // 予約編集
        Route::put('/reservations/{reservation}', 'update')->name('reservations.update');      // 予約更新
        Route::delete('/reservations/{reservation}', 'destroy')->name('reservations.destroy'); // 予約削除
    });

    // ----------------------
    // お気に入り関連（例）
    // ----------------------
    Route::controller(FavoriteController::class)->group(function () {
   
    Route::get('/favorites', 'index')->name('favorites.index'); // お気に入り一覧
    Route::post('/stores/{store}/favorite', 'toggle')->name('favorites.toggle');

    // 通常削除用（必要なら残す）
    Route::delete('/stores/{store}/favorite', 'destroy')->name('favorites.destroy');
    });  

});
