<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * マイグレーションの実行
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('postal_code');
            $table->string('address');
            $table->string('representative');
            $table->string('establishment_date');
            $table->string('capital');
            $table->string('business');
            $table->string('number_of_employees');
            $table->timestamps();
        });
    }

    /**
     * マイグレーションのロールバック
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
