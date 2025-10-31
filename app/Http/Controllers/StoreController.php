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
}
