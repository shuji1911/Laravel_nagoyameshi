<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\CardException;

class SubscriptionController extends Controller {
    public function create() {
        $intent = Auth::user()->createSetupIntent();

        return view('subscription.create', compact('intent'));
    }

    public function store(Request $request) {
        $request->validate([
            'paymentMethodId' => 'required|string',
        ]);

        try {
            $request->user()->newSubscription(
                'premium_plan',
                'price_1PjzTdCzyQSNFj3NlYm7tDkn'
            )->create($request->paymentMethodId);
        } catch (CardException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('home')->with('flash_message', '有料会員登録が完了しました。');
    }

    public function edit() {
        $user = Auth::user();
        $intent = Auth::user()->createSetupIntent();

        return view('subscription.edit', compact('user','intent'));
    }

    public function update(Request $request) {
        $request->validate([
            'paymentMethodId' => 'required|string',
        ]);

        try {
            $request->user()->updateDefaultPaymentMethod($request->paymentMethodId);
        } catch (CardException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('home')->with('flash_message', 'クレジットカード情報を編集しました。');
    }

    public function cancel() {
        return view('subscription.cancel');
    }

    public function destroy() {
        try {
            Auth::user()->subscription('premium_plan')->cancelNow();
        } catch (\Exception $e) {
            return redirect()->route('home')->withErrors(['error' => 'サブスクリプションのキャンセルに失敗しました。']);
        }

        return redirect()->route('home')->with('flash_message', '有料会員を解約しました。');
    }
}
