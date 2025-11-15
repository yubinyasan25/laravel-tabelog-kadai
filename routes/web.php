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
    PaidMemberController
};

// トップページ
Route::get('/', [WebController::class, 'index'])->name('top');

// 店舗（一般ユーザー用）
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/{id}', [StoreController::class, 'show'])->name('stores.show');

// 認証ルート
require __DIR__.'/auth.php';

// 認証・メール認証済みユーザー用
Route::middleware(['auth', 'verified'])->group(function () {

    // マイページなど
    Route::controller(UserController::class)->group(function () {
        Route::get('users/mypage', 'mypage')->name('users.mypage');
        // ...その他マイページルート
    });

    
    // 予約管理
    Route::controller(ReservationController::class)->group(function () {
        Route::get('reservations', 'index')->name('reservations.index');
        Route::delete('reservations/{id}', 'destroy')->name('reservations.destroy');
    });

    // 有料会員登録（Stripe Checkout）
    Route::get('/paid/register', [PaidMemberController::class, 'showForm'])->name('paid.register');
    Route::post('/paid/checkout', [PaidMemberController::class, 'createCheckoutSession'])->name('paid.session');
    Route::get('/paid/success', [PaidMemberController::class, 'success'])->name('paid.success');
    Route::get('/paid/cancel', [PaidMemberController::class, 'cancelPage'])->name('paid.cancelPage');
    Route::post('/paid/cancel', [PaidMemberController::class, 'cancel'])->name('paid.cancel');

    // 有料会員限定機能（予約・レビュー・お気に入り）
    Route::middleware(['paid'])->group(function () {
        Route::get('/stores/{id}/reserve', [ReservationController::class, 'create'])->name('stores.reserve_form');
        Route::post('/stores/{id}/reserve', [ReservationController::class, 'store'])->name('stores.reserve');

        Route::post('/stores/{store}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::post('/stores/{store}/favorite', [FavoriteController::class, 'toggle'])->name('stores.favorite.toggle');
        Route::post('/stores/{store}/favorite/add', [FavoriteController::class, 'store'])->name('stores.favorite.store');
        Route::delete('/stores/{store}/favorite/remove', [FavoriteController::class, 'destroy'])->name('stores.favorite.destroy');
        Route::get('/mypage/favorite-stores', [FavoriteController::class, 'index'])->name('mypage.favorite_stores');
    });

        Route::get('users/mypage/edit', [UserController::class, 'edit'])
        ->middleware(['auth', 'verified'])
        ->name('users.mypage.edit');

        // パスワード編集ページ
    Route::get('users/mypage/password/edit', [UserController::class, 'edit_password'])
    ->middleware(['auth', 'verified'])
    ->name('mypage.edit_password');

    // パスワード更新処理
    Route::put('users/mypage/password', [UserController::class, 'update_password'])
    ->middleware(['auth', 'verified'])
    ->name('mypage.update_password');


});
