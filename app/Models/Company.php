<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'companies';

    // マスアサイメント可能な属性を指定
    protected $fillable = [
        'name',
        'postal_code',
        'address',
        'representative',
        'establishment_date',
        'capital',
        'business',
        'number_of_employees',
    ];

    // タイムスタンプの仕様を明示的に設定(デフォルトで使用される）
    public $timestamps = true;
}
