<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class WebController extends Controller
{
    public function index()
    {
        // サイドバー用カテゴリを取得
        $categories = Category::all();

        // 商品一覧を取得
        $recently_products = Product::orderBy('created_at', 'desc')->take(4)->get();
        $recommend_products = Product::where('recommend_flag', true)->take(3)->get();
        $featured_products = Product::withAvg('reviews', 'score')->orderBy('reviews_avg_score', 'desc')->take(4)->get();

        // ビューに渡す
        return view('web.index', compact('categories', 'recently_products', 'recommend_products', 'featured_products'));
    }
}
