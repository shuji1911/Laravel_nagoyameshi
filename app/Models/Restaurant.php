<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Restaurant extends Model {
    use HasFactory;
    use Sortable;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public $sortable = ['lowest_price', 'highest_price'];

    public function scoreSortable($query, $direction) {
        return $query->orderBy('reviews_avg_score', $direction);
    }
}
