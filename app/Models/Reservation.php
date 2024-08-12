<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // マスアサインメント可能な属性を定義
    protected $fillable = [
        'reserved_datetime', // ここに追加
        'restaurant_id',    // 他に必要な属性も追加する
        'user_id',          // 他に必要な属性も追加する
        // ここに他のフィールドも追加できます
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
