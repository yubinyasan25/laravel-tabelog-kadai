<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    // マイページ表示
    public function index()
    {
        return view('users.mypage');
    }

    // 会員情報編集ページ
    public function edit()
    {
       $user = Auth::user();
       return view('users.edit', compact('user'));
    }

    // 注文履歴ページ
    public function cart_history()
    {
        return view('users.cart_history_index'); // ← ファイル名に合わせる
    }

    // パスワード変更ページ
    public function edit_password()
    {
        return view('users.edit_password'); // ← ファイル名に合わせる
    }
}
