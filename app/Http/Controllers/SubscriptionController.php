<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class SubscriptionController extends Controller
{
    // サブスク登録ボタン押下時
    public function subscribe()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = Session::create([
            'customer_email' => Auth::user()->email,
            'line_items' => [[
                'price' => env('STRIPE_MONTHLY_PRICE_ID'),
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('subscription.success'),
            'cancel_url' => route('subscription.cancel'),
        ]);

        return redirect($checkout_session->url);
    }

    // 登録成功時
    public function success()
    {
        $user = Auth::user();
        $user->is_paid = true;  // ← フラグ名を統一
        $user->stripe_subscription_id = 'test_sub_' . uniqid();
        $user->save();

        Auth::setUser($user->fresh()); // 最新情報に更新

        return view('subscription.success');
    }

    // キャンセル時
    public function cancel()
    {
         $user = Auth::user();

        // 仮IDを使った解約処理（テスト用）
        $user->is_paid = false;  // ← フラグ名を統一
        $user->stripe_subscription_id = null;
        $user->save();
        Auth::setUser($user->fresh());

        return view('subscription.cancel');
    }
}
