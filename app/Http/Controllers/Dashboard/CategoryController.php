<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $keyword = $request->input('keyword');

        if ($keyword) {
            $categories = Category::where('name', 'like', "%{$keyword}%")->paginate(10);
        } else {
            $categories = Category::paginate(10);
        }

        return view('dashboard.categories.index', compact('categories', 'keyword'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('dashboard.categories.index')->with('flash_message', 'カテゴリを作成しました。');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category) {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category) {
        $request->validate([
            'name' => 'required',
        ]);

        $category->name = $request->input('name');
        $category->save();

        return redirect()->route('dashboard.categories.index')->with('flash_message', 'カテゴリを編集しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) {
        $category->delete();

        return redirect()->route('dashboard.categories.index')->with('flash_message', 'カテゴリを削除しました。');
    }
}
