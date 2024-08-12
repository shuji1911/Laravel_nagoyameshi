<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company; // 会社情報を管理するモデルをインポートする

class CompanyController extends Controller
{
    public function index()
    {
        // companiesテーブルの最初のデータを取得
        $company = Company::first();
        
        // ビューにデータを渡す
        return view('company.index', ['company' => $company]);
    }
}

