<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;

class StoreController extends Controller
{
    /**
     * 店舗一覧ページ（検索含む）
     */
    public function index(Request $request)
    {
        // 🔍 検索キーワードを取得
        $keyword = $request->input('keyword');

        // クエリビルダーを作成
        $query = Store::query();

        // 検索キーワードがある場合、店舗名・説明・住所を部分一致検索
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
        }

        // 検索または全件を取得（おすすめ順）
        $stores = $query->orderBy('recommend_flag', 'desc')->get();

        // カテゴリを全件取得
        $categories = Category::all();

        // ビューに渡す
        return view('stores.index', compact('stores', 'categories', 'keyword'));
    }

    /**
     * 店舗詳細ページ
     */
    public function show($id)
    {
        // 指定IDの店舗を取得（見つからなければ404）
        $store = Store::findOrFail($id);

        // 全カテゴリを取得（サイドバー等に使う想定）
        $categories = Category::all();

        // ビューに渡す
        return view('stores.show', compact('store', 'categories'));
    }
}
