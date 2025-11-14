<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class SubscriptionController extends Controller
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET'));
    }

    /**
     * 有料会員登録（クレカ登録）
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $user = auth()->user();
        $stripe = $this->stripe;

        // 1) Stripe Customer を未作成なら作成
        if (!$user->stripe_customer_id) {
            $customer = $stripe->customers->create([
                'email' => $user->email,
                'name'  => $user->name,
            ]);

            $user->stripe_customer_id = $customer->id;
            $user->save();
        }

        // 2) 支払い方法を Customer に紐づけ
        $stripe->paymentMethods->attach(
            $request->payment_method,
            ['customer' => $user->stripe_customer_id]
        );

        // 3) デフォルトカードとして登録
        $stripe->customers->update($user->stripe_customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $request->payment_method,
            ],
        ]);

        // 4) DB に保存
        $user->update([
            'stripe_payment_method_id' => $request->payment_method,
            'is_paid_member' => true,
        ]);

        return redirect()->route('mypage.index')
            ->with('success', '有料会員登録が完了しました！');
    }

    /**
     * マイページでカード情報を表示
     */
    public function mypageCard()
    {
        $user = Auth::user();
        $card = null;

        if ($user->stripe_payment_method_id) {
            try {
                $card = $this->stripe->paymentMethods->retrieve(
                    $user->stripe_payment_method_id
                );
            } catch (\Exception $e) {
                $card = null;
            }
        }

        return view('users.mypage', compact('card'));
    }

    /**
     * カード情報の更新
     */
    public function editCard(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();
        $stripe = $this->stripe;

        // 新カードを customer に紐付け
        $stripe->paymentMethods->attach($request->payment_method, [
            'customer' => $user->stripe_customer_id,
        ]);

        // デフォルトカードに設定
        $stripe->customers->update($user->stripe_customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $request->payment_method,
            ],
        ]);

        // DB 更新
        $user->stripe_payment_method_id = $request->payment_method;
        $user->save();

        return redirect()->route('mypage.index')
            ->with('success', 'カード情報を更新しました');
    }

    /**
     * 有料会員退会（カード削除 + サブスク停止）
     */
    public function deleteCard(Request $request)
    {
        $user = Auth::user();
        $stripe = $this->stripe;

        // Stripe Payment Method 削除
        if ($user->stripe_payment_method_id) {
            try {
                $stripe->paymentMethods->detach($user->stripe_payment_method_id);
            } catch (\Exception $e) { }
        }

        // サブスクがあればキャンセル
        if ($user->stripe_subscription_id) {
            try {
                $stripe->subscriptions->cancel($user->stripe_subscription_id);
            } catch (\Exception $e) { }
        }

        // DB をクリア
        $user->stripe_payment_method_id = null;
        $user->stripe_subscription_id = null;
        $user->is_paid_member = false;
        $user->save();

        return redirect()->route('mypage.index')
            ->with('success', '有料会員を退会しました');
    }

    /**
     * サブスクCheckout成功時 (必要なら使用)
     */
    public function success(Request $request)
    {
        $user = Auth::user();

        $subscriptionId = $request->query('subscription_id');
        $paymentMethodId = $request->query('payment_method_id');

        $user->is_paid_member = true;
        $user->stripe_subscription_id = $subscriptionId;
        $user->stripe_payment_method_id = $paymentMethodId;
        $user->save();

        return view('subscription.success');
    }

    /**
     * キャンセル時
     */
    public function cancel()
    {
        $user = Auth::user();
        $stripe = $this->stripe;

        if ($user->stripe_payment_method_id) {
            try {
                $stripe->paymentMethods->detach($user->stripe_payment_method_id);
            } catch (\Exception $e) {}
        }

        if ($user->stripe_subscription_id) {
            try {
                $stripe->subscriptions->cancel($user->stripe_subscription_id);
            } catch (\Exception $e) {}
        }

        $user->stripe_payment_method_id = null;
        $user->stripe_subscription_id = null;
        $user->is_paid_member = false;
        $user->save();

        return view('subscription.cancel');
    }
        public function subscribe()
    {
        // 有料会員登録ページにリダイレクトする例
        return view('paid_member.register');
    }


}
