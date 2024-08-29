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

    // タイムスタンプを使用する
    public $timestamps = true;

    // 定休日との多対多リレーション
    public function regular_holidays()
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
    public $sortable = ['lowest_price', 'highest_price', 'rating'];

    // ソート機能のカスタマイズ
    public function scopeRatingSortable($query, $direction)
    {
        return $query->leftJoin('reviews', 'restaurants.id', '=', 'reviews.restaurant_id')
                     ->select('restaurants.*', \DB::raw('AVG(reviews.score) as reviews_avg_score'))
                     ->groupBy('restaurants.id')
                     ->orderBy('reviews_avg_score', $direction);
    
    }
    public function scopePopularSortable($query)
    {
        return $query->withCount('reservations')
                     ->orderBy('reservations_count', 'desc');
    }
    // 多対多のリレーションシップを定義
    public function users()
    {
        return $this->belongsToMany(User::class, 'restaurant_user')
        ->withTimestamps();
    }
}
