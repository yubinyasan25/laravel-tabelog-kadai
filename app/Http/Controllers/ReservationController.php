<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Store;

class ReservationController extends Controller
{
    /**
     * 予約フォームを表示
     */
    public function create($store_id)
    {
        $store = Store::findOrFail($store_id);

        // 有料会員のみ予約可能
        if (!Auth::user()->is_paid_member) {
            return redirect()->route('plans.index')->with('error', '予約機能は有料会員限定です。');
        }

        // 専用ビューに変更（stores.show ではなく reservations.create）
        return view('reservations.create', compact('store'));
    }

    /**
     * 予約を保存
     */
    public function store(Request $request, $store_id)
    {
        

        // バリデーション追加（11〜22時、1〜50人）
        $validated = $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if ($value < '11:00' || $value > '22:00') {
                        $fail('予約時間は11:00〜22:00の間で指定してください。');
                    }
                },
            ],
            'people' => 'required|integer|min:1|max:50',
        ]);

        // 日時を結合して保存
        $datetime = $validated['reservation_date'] . ' ' . $validated['reservation_time'];

        Reservation::create([
            'user_id' => Auth::id(),
            'store_id' => $store_id,
            'reservation_datetime' => $datetime,
            'number_of_people' => $validated['people'],
        ]);

        return redirect()->route('reservations.index')->with('success', '予約が完了しました！');
    }

    /**
     * 自分の予約一覧
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('store')
            ->orderBy('reservation_datetime', 'asc')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * 予約を削除
     */
    public function destroy($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', '予約をキャンセルしました。');
    }
}
