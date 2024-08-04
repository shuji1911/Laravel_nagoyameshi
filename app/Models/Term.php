<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'terms';

    // マスアサイメント可能な属性を指定
    protected $fillable = [
        'content',
    ];

    // タイムスタンプの仕様を明示的に設定(デフォルトで使用される）
    public $timestamps = true;
}
