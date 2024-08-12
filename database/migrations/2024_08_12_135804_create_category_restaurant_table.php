<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_restaurant', function (Blueprint $table) {
            $table->id(); // ID
            $table->foreignId('restaurant_id') // 店舗のID
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('category_id') // カテゴリのID
                  ->constrained()
                  ->cascadeOnDelete();
            $table->timestamps(); // 作成日時と更新日時
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_restaurant');
    }
};
