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

       

        // ビューに渡す
        return view('web.index', compact('categories', 'recently_products', 'recommend_products', 'featured_products'));
    }
}
