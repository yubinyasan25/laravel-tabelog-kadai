<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;

class StoreController extends Controller
{
    /**
     * 店舗一覧ページ
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

    
        // 店舗を全件取得（おすすめ順にソート）
        $stores = Store::orderBy('recommend_flag', 'desc')->get();

        // カテゴリを全件取得
        $categories = Category::all();

        // ビューに渡す
        return view('stores.index', compact('stores', 'categories'));
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

    public function search(Request $request)
{
    $keyword = $request->input('keyword');

    // 検索処理（名前 or 説明に部分一致）
    $stores = Store::where('name', 'like', "%{$keyword}%")
        ->orWhere('description', 'like', "%{$keyword}%")
        ->get();

    $categories = Category::all();

    return view('stores.index', compact('stores', 'categories'))
        ->with('keyword', $keyword);
}

    
}