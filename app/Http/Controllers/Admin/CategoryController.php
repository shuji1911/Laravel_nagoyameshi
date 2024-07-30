<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Conroller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        
        // 検索クエリを構築
        $query = Category::query();
        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
        
        // ページネーションを適用
        $categories = $query->paginate(10);
        
        // 総数を取得
        $total = $query->count();
        
        return view('admin.categories.index', compact('categories', 'keyword', 'total'));
    }

    public function store(Request $request)
{
    // バリデーション
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // 新しいカテゴリを作成
    Category::create($validatedData);

    // フラッシュメッセージとリダイレクト
    return redirect()->route('admin.categories.index')
                     ->with('flash_message', 'カテゴリを登録しました。');
}

public function update(Request $request, Category $category)
{
    // バリデーション
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // カテゴリを更新
    $category->update($validatedData);

    // フラッシュメッセージとリダイレクト
    return redirect()->route('admin.categories.index')
                     ->with('flash_message', 'カテゴリを編集しました。');
}

public function destroy(Category $category)
{
    // カテゴリを削除
    $category->delete();

    // フラッシュメッセージとリダイレクト
    return redirect()->route('admin.categories.index')
                     ->with('flash_message', 'カテゴリを削除しました。');
}


}
