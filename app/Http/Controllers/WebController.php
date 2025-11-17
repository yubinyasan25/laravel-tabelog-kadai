<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class WebController extends Controller
{
    public function index()
    {
        // サイドバー用カテゴリを取得
        $categories = Category::all();

        // カテゴリだけをビューへ渡す
        return view('web.index', compact('categories'));
    }
}
