<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MypageController extends Controller
{
    // マイページ表示
    public function index()
    {
        return view('users.mypage');
    }

    // 会員情報編集ページ（必要なら追加）
    public function edit()
    {
        return view('mypage.edit');
    }

    // 注文履歴ページ（必要なら追加）
    public function cart_history()
    {
        return view('mypage.cart_history');
    }

    // パスワード変更ページ（必要なら追加）
    public function edit_password()
    {
        return view('mypage.edit_password');
    }
}
