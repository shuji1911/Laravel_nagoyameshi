<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller {
    public function edit() {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    public function update(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'postal_code' => ['required', 'digits:7'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required'],
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->phone_number = $request->input('phone_number');
        $user->save();

        return redirect()->route('user.edit')->with('flash_message', '会員情報を編集しました。');
    }
}
