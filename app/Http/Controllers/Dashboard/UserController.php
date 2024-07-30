<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {
    public function index(Request $request) {
        $keyword = $request->input('keyword');
        $subscriptions_query = DB::table('subscriptions');

        if ($keyword) {
            $users = User::where('name', 'like', "%{$keyword}%")->paginate(10);
        } else {
            $users = User::paginate(10);
        }

        return view('dashboard.users.index', compact('users', 'keyword', 'subscriptions_query'));
    }

    public function show(User $user) {
        $subscriptions_query = DB::table('subscriptions');

        return view('dashboard.users.show', compact('user', 'subscriptions_query'));
    }
}
