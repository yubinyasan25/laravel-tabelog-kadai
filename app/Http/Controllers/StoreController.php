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

        // 🔹 カテゴリIDからカテゴリ名を取得
        $selectedCategory = null;
        if (!empty($categoryId)) {
            $selectedCategory = Category::find($categoryId);

            // 🔹 「ALL」カテゴリ以外のときだけ絞り込み
            if ($selectedCategory && $selectedCategory->name !== 'ALL') {
                $query->where('category_id', $categoryId);
            }
        }

        // おすすめ順で取得
        $stores = $query->orderBy('recommend_flag', 'desc')->get();

        // 全カテゴリ取得（サイドバーやボタン表示用）
        $categories = Category::all();

        // ビューに渡す（categoryIdも渡す）
        return view('stores.index', compact('stores', 'categories', 'keyword', 'categoryId','selectedCategory'));
    }

    /**
     * 店舗詳細ページ
     */
    public function show($id)
    {
        // レビューもユーザー情報付きで取得（全件取得）
        $store = Store::with('reviews.user')->findOrFail($id);

        // 全カテゴリ取得（サイドバー用）
        $categories = Category::all();

        return view('stores.show', compact('store', 'categories'));
    }

    /**
     * 予約フォームの送信処理
     */
    public function reserve(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        $request->validate([
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'people' => 'required|integer|min:1|max:20',
        ]);

        // 予約作成
        $store->reservations()->create([
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'people' => $request->people,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('stores.show', $store->id)
                         ->with('success', '予約が完了しました。');
    }
}
