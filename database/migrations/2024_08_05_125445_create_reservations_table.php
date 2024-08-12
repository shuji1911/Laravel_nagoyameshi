<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // ID
            $table->datetime('reserved_datetime'); // 予約日時
            $table->integer('number_of_people')->nullable(); // 予約人数
            $table->foreignId('restaurant_id') // 店舗のID
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('user_id') // 会員のID
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
        Schema::dropIfExists('reservations');
    }
}
