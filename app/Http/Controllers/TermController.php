<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Term; // 利用規約を管理するモデルをインポートする

class TermController extends Controller
{
    public function index()
    {
        // termsテーブルの最初のデータを取得
        $term = Term::first();
        
        // ビューにデータを渡す
        return view('terms.index', ['term' => $term]);
    }
}
