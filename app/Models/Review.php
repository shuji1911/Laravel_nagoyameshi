<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // テーブル名がデフォルトの複数形でない場合に指定
    protected $table = 'reviews';

    // マスアサイメント可能な属性
    protected $fillable = [
        'content',
        'score',
        'restaurant_id',
        'user_id',
    ];

    // 店舗とのリレーション
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
