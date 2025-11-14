<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaidMemberController extends Controller
{
    /**
     * 有料会員登録画面を表示
     */
    public function showForm()
    {
        $user = auth()->user();
        $card = null;

        if ($user->stripe_payment_method_id) {
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            $card = $stripe->paymentMethods->retrieve($user->stripe_payment_method_id);
        }

        return view('paid_member.register', compact('card'));
    }

    /**
     * ① 有料会員登録（カード登録）
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $user = auth()->user();
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        // Stripe Customer が無ければ作成
        if (!$user->stripe_customer_id) {
            $customer = $stripe->customers->create([
                'email' => $user->email,
                'name'  => $user->name,
            ]);

            $user->stripe_customer_id = $customer->id;
            $user->save();
        }

        // PaymentMethod を Stripe Customer に登録
        $stripe->paymentMethods->attach(
            $request->payment_method,
            ['customer' => $user->stripe_customer_id]
        );

        // デフォルト支払方法として設定
        $stripe->customers->update($user->stripe_customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $request->payment_method,
            ],
        ]);

        // DB 更新
        $user->update([
            'stripe_payment_method_id' => $request->payment_method,
            'is_paid_member' => true,
        ]);

        return redirect()->route('users.mypage')->with('success', '有料会員登録が完了しました！');
    }

    /**
     * ② カード変更（マイページで更新）
     */
    public function updateCard(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $user = auth()->user();
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        // 既存カードがあれば detach
        if ($user->stripe_payment_method_id) {
            $stripe->paymentMethods->detach(
                $user->stripe_payment_method_id
            );
        }

        // 新しいカードを attach
        $stripe->paymentMethods->attach(
            $request->payment_method,
            ['customer' => $user->stripe_customer_id]
        );

        // デフォルト支払方法を更新
        $stripe->customers->update($user->stripe_customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $request->payment_method,
            ],
        ]);

        // DB 更新
        $user->update([
            'stripe_payment_method_id' => $request->payment_method,
        ]);

        return back()->with('success', 'カード情報を更新しました！');
    }

    /**
     * ③ 有料会員退会（カード削除＋フラグOFF）
     */
    public function cancel()
    {
        $user = auth()->user();
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        // Stripe のカード削除
        if ($user->stripe_payment_method_id) {
            $stripe->paymentMethods->detach(
                $user->stripe_payment_method_id
            );
        }

        // DB 側をリセット
        $user->update([
            'is_paid_member' => false,
            'stripe_payment_method_id' => null,
        ]);

        return redirect()->route('mypage.index')->with('success', '有料会員を退会しました。');
    }

    
}
