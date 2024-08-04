<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularHoliday extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'regular_holidays';

    // マスアサイメント可能な属性を指定
    protected $fillable = [
        'day',
        'day_index',
    ];

    // タイムスタンプの仕様を明示的に設定（デフォルトで使用される）
    public $timestamps = true;

    // 店舗との多対多リレーション
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'regular_holiday_restaurant');
    }
}
