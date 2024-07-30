<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->default('');
            $table->text('description');
            $table->unsignedInteger('lowest_price');
            $table->unsignedInteger('highest_price');
            $table->string('postal_code');
            $table->string('address');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->unsignedInteger('seating_capacity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('restaurants');
    }
};
