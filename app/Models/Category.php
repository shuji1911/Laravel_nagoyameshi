<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    use HasFactory;

    protected $fillable = [
        'name',  // この行を追加します
        // 他にマスアサインメントを許可する属性があれば追加してください
    ];

    // テーブル名
    protected $table = 'categories';
    
    // 多対多のリレーションシップの設定
    public function restaurants() {
        return $this->belongsToMany(Restaurant::class, 'category_restaurant');
    }
}
