<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Restaurant extends Model
{
    use HasFactory, Sortable;

    // マスアサイメント可能な属性
    protected $fillable = [
        'name',
        'image',
        'description',
        'lowest_price',
        'highest_price',
        'postal_code',
        'address',
        'opening_time',
        'closing_time',
        'seating_capacity',
    ];

    // テーブル名
    protected $table = 'restaurants';


    public $timestamps = true;

    // 定休日との多対多リレーション
    public function regularHolidays()
    {
        return $this->belongsToMany(RegularHoliday::class, 'regular_holiday_restaurant');
    }

    // カテゴリとの多対多リレーション
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_restaurant');
    }

    // レビューとのリレーション
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 予約とのリレーション
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // ソート可能なカラムの定義
    public $sortable = ['lowest_price', 'highest_price'];

    // ソート機能のカスタマイズ
    public function scoreSortable($query, $direction)
    {
        return $query->orderBy('reviews_avg_score', $direction);
    }
}
