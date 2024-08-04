<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller {
    // 会員情報ページ
    public function index() {
        $user = Auth::user();
        return view('user.index', compact('user'));
    }

    // 会員情報編集ページ
    public function edit() {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    // 会員情報更新機能
    public function update(Request $request) {
        // バリデーション
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ヶー\s]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'postal_code' => ['required', 'digits:7'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'digits_between:10,11'],
            'birthday' => ['nullable', 'digits:8'],
            'occupation' => ['nullable', 'string', 'max:255'],
        ]);

        // 現在ログイン中のユーザーを取得
        $user = Auth::user();
        
        // ユーザー情報の更新
        $user->update($validatedData);

        // 会員情報編集ページにリダイレクトしてフラッシュメッセージを保存
        return redirect()->route('user.index')->with('flash_message', '会員情報を編集しました。');
    }
}
