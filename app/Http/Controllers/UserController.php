<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // マイページ表示
    public function mypage()
    {
        $user = auth()->user();
        return view('users.mypage', compact('user'));
    }

    // 会員情報編集フォーム
    public function edit()
    {
        $user = auth()->user();
        return view('users.edit', compact('user'));
    }

    // 会員情報更新処理
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'postal_code' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $user->update($request->only('name','email','postal_code','address','phone'));

        return redirect()->route('users.mypage')->with('success', '会員情報を更新しました');
    }

    // パスワード編集フォーム
    public function editPassword()
    {
        $user = auth()->user();
        return view('users.edit_password', compact('user'));
    }

    // パスワード更新処理
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.mypage')->with('success', 'パスワードを更新しました');
    }

    // 退会処理
    public function destroy()
    {
        $user = auth()->user();
        $user->delete();

        return redirect('/')->with('success', '退会しました');
    }
}
