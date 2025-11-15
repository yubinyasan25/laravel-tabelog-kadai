<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class FavoriteController extends Controller
{
    // 通常フォーム用追加（リダイレクト）
    public function store($store_id)
    {
        $user = Auth::user();
        if (!$user->is_paid) {
            return redirect()->back()->with('error', 'お気に入りは有料会員限定です。');
        }
        $user->favorite_stores()->syncWithoutDetaching([$store_id]);
        return back()->with('success', 'お気に入りに追加しました。');
    }

    // 通常フォーム用削除（リダイレクト）
    public function destroy($store_id)
    {
        $user = Auth::user();
        if (!$user->is_paid) {
            return redirect()->back()->with('error', '操作できません。');
        }
        $user->favorite_stores()->detach($store_id);
        return back()->with('success', 'お気に入りを解除しました。');
    }

    // Ajax用お気に入りトグル（追加/削除）
    public function toggle($store_id)
    {
        $user = Auth::user();
        if (!$user->is_paid) {
            return response()->json(['status' => 'error', 'message' => '有料会員限定です'], 403);
        }

        $store = Store::findOrFail($store_id);
        $user->load('favorite_stores');

        if ($user->favorite_stores->contains($store->id)) {
            $user->favorite_stores()->detach($store->id);
            return response()->json(['status' => 'removed']);
        } else {
            $user->favorite_stores()->attach($store->id);
            return response()->json(['status' => 'added']);
        }
    }
 
    // =========================
    // お気に入り一覧（マイページ用）
    // =========================
    public function index()
    {
    $user = auth()->user();

    // 有料会員限定
    if (!$user->is_paid) {
        return redirect()->route('users.mypage')->with('error', 'お気に入り一覧は有料会員限定です。');
    }

    // お気に入り店舗一覧を取得
    $favorite_stores = $user->favorite_stores()->paginate(10);

    return view('mypage.favorite_stores', compact('favorite_stores'));
    }



}
