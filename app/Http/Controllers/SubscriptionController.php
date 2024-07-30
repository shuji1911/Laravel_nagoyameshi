<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller {
    public function create() {
        $intent = Auth::user()->createSetupIntent();

        return view('subscription.create', compact('intent'));
    }

    public function store(Request $request) {
        $request->user()->newSubscription(
            'basic_plan',
            'price_1MJ5FIIXjS4orlsmgKuetEPy'
        )->create($request->paymentMethodId);

        return redirect()->route('mypage')->with('flash_message', '有料会員登録が完了しました。');
    }

    public function edit() {
        $user = Auth::user();
        $intent = Auth::user()->createSetupIntent();

        return view('subscription.edit', compact('user', 'intent'));
    }

    public function update(Request $request) {
        $request->user()->updateDefaultPaymentMethod($request->paymentMethodId);

        return redirect()->route('mypage')->with('flash_message', 'クレジットカード情報を編集しました。');
    }

    public function cancel() {
        return view('subscription.cancel');
    }

    public function destroy() {
        Auth::user()->subscription('basic_plan')->cancelNow();

        return redirect()->route('mypage')->with('flash_message', '有料会員を解約しました。');
    }
}
