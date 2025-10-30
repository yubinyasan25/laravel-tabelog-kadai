<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * 店舗一覧ページ
     */
    public function index()
    {
        // 店舗を全件取得（おすすめ順にソート）
        $stores = Store::orderBy('recommend_flag', 'desc')->get();

        // ビューに渡す
        return view('stores.index', compact('stores'));
    }
}
