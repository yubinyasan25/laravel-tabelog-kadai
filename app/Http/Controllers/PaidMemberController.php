<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Subscription;
use App\Models\User;

class PaidMemberController extends Controller
{
    /**
     * 有料会員登録ページ
     */
    public function showForm()
    {
         $user = auth()->user();

    // すでに有料会員ならマイページへリダイレクト
    if ($user->is_paid_member) {
        return redirect()->route('users.mypage')
            ->with('success', '既に有料会員です');
    }

    return view('paid_member.register');
    }

    /**
     * Stripe Checkout セッション作成
     */
    public function createCheckoutSession()
    {
        $user = auth()->user();

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'mode' => 'subscription', // 定期課金
            'line_items' => [[
                'price' => env('STRIPE_PRICE_ID'),
                'quantity' => 1,
            ]],
            'customer_email' => $user->email,
            // Checkout セッション ID を success_url に渡す
            'success_url' => route('paid.success', ['session_id' => '{CHECKOUT_SESSION_ID}']),
            'cancel_url'  => route('paid.cancelPage'),
        ]);

        return redirect($session->url);
    }

    /**
     * 決済成功ページ（安全に有料会員反映）
     */
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect()->route('paid.register')->with('error', 'セッションIDがありません');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Checkout セッションを取得
            $session = StripeSession::retrieve($sessionId);
            $subscriptionId = $session->subscription;
            $customerEmail = $session->customer_email;

            // Subscription の状態を確認
            $subscription = Subscription::retrieve($subscriptionId);

            if (!in_array($subscription->status, ['active', 'trialing'])) {
                return redirect()->route('paid.register')->with('error', 'サブスクが有効ではありません');
            }

            // DB 更新
            $user = User::where('email', $customerEmail)->firstOrFail();
            $user->is_paid_member = true;
            $user->stripe_subscription_id = $subscriptionId;
            $user->save();

        } catch (\Exception $e) {
            return redirect()->route('paid.register')->with('error', 'Stripe情報の取得に失敗しました: '.$e->getMessage());
        }

        return view('paid_member.success');
    }

    /**
     * キャンセルページ
     */
    public function cancelPage()
    {
        return view('paid_member.cancel');
    }

    /**
     * 有料会員退会（DB反映のみ、Webhook不要）
     */
    public function cancel()
    {
        $user = auth()->user();
        $user->is_paid_member = false;
        $user->stripe_subscription_id = null;
        $user->save();

        return redirect()->route('users.mypage')->with('success', '有料会員を退会しました');
    }
}
