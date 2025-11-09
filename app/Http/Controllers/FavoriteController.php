<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class FavoriteController extends Controller
{
    // お気に入り追加
    public function store($store_id)
    {
        Auth::user()->favorite_stores()->attach($store_id);
        return back();
    }

    // お気に入り削除
    public function destroy($store_id)
    {
        Auth::user()->favorite_stores()->detach($store_id);
        return back();
    }

    // ※任意：Ajax用トグルメソッド
    public function toggle($store_id)
    {
        $user = Auth::user();
        $store = Store::findOrFail($store_id);

        if ($user->favorite_stores->contains($store->id)) {
            $user->favorite_stores()->detach($store->id);
            return response()->json(['status' => 'removed']);
        } else {
            $user->favorite_stores()->attach($store->id);
            return response()->json(['status' => 'added']);
        }
    }
}
