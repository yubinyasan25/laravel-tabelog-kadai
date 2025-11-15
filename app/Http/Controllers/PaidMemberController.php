<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 

class PaidMemberController extends Controller
{
    // 有料会員登録ページ
    public function showForm()
    {
        $user = auth()->user();

        if ($user->is_paid_member) {
            return redirect()->route('users.mypage')->with('success', '既に有料会員です');
        }

        return view('paid_member.register');
    }

    // Stripe Checkout セッション作成
    public function createCheckoutSession()
    {
        $user = auth()->user();

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => env('STRIPE_PRICE_ID'),
                'quantity' => 1,
            ]],
            'customer_email' => $user->email,
            'success_url' => route('paid.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('paid.cancelPage'),
        ]);

        return redirect($session->url);
    }

    // 決済成功ページ
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
    if (!$sessionId) {
        return redirect()->route('paid.register')->with('error', 'セッションIDがありません');
    }

    Stripe::setApiKey(env('STRIPE_SECRET'));

    try {
        $session = StripeSession::retrieve($sessionId);
        $subscriptionId = $session->subscription;
        $customerEmail = $session->customer_email;

        $subscription = Subscription::retrieve($subscriptionId);

        if (!in_array($subscription->status, ['active', 'trialing'])) {
            return redirect()->route('paid.register')->with('error', 'サブスクが有効ではありません');
        }

        $user = User::where('email', $customerEmail)->firstOrFail();
        $user->is_paid_member = true;
        $user->stripe_subscription_id = $subscriptionId;
        $user->save();

        // セッション反映
        Auth::login($user);

    } catch (\Exception $e) {
        return redirect()->route('paid.register')->with('error', 'Stripe情報の取得に失敗しました: ' . $e->getMessage());
    }
        return view('subscription.success');
    }

    // キャンセルページ
    public function cancelPage()
    {
        return view('subscription.cancel');
    }

    // 有料会員退会
    public function cancel()
    {
        $user = auth()->user();
        $user->is_paid_member = false;
        $user->stripe_subscription_id = null;
        $user->save();

        return redirect()->route('users.mypage')->with('success', '有料会員を退会しました');
    }
}
