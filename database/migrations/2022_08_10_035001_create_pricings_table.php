<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('pricing_name');
            $table->string('pricing_type');
            $table->string('pricing_desc');
            $table->string('pricing_detail_1')->nullable();
            $table->string('pricing_detail_2')->nullable();
            $table->string('pricing_detail_3')->nullable();
            $table->string('pricing_detail_4')->nullable();
            $table->string('pricing_detail_5')->nullable();
            $table->string('pricing_detail_6')->nullable();
            $table->string('pricing_detail_7')->nullable();
            $table->string('pricing_detail_8')->nullable();
            $table->string('pricing_detail_9')->nullable();
            $table->string('pricing_detail_10')->nullable();
            $table->bigInteger('pricing_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricings');
    }
}
