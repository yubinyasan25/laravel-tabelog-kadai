<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Category;

class StoreController extends Controller
{
    /**
     * 店舗一覧ページ（検索＋カテゴリ絞り込み）
     */
    public function index(Request $request)
    {
        // 🔍 検索キーワードとカテゴリIDを取得
        $keyword = $request->input('keyword');
        $categoryId = $request->input('category');

        // クエリビルダー作成
        $query = Store::query();

        // キーワード検索
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        // カテゴリ絞り込み
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // おすすめ順で取得
        $stores = $query->orderBy('recommend_flag', 'desc')->get();

        // 全カテゴリ取得（サイドバーやボタン表示用）
        $categories = Category::all();

        // ビューに渡す（categoryIdも渡す）
        return view('stores.index', compact('stores', 'categories', 'keyword', 'categoryId'));
    }

    /**
     * 店舗詳細ページ
     */
    public function show($id)
    {
        $store = Store::findOrFail($id);
        $categories = Category::all();

        return view('stores.show', compact('store', 'categories'));
    }
}
