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
    public function index()
    {
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
}