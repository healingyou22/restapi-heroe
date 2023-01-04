<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('pricing_id');
            $table->foreign('pricing_id')->references('id')->on('pricings')->onDelete('cascade');
            $table->string('full_name');
            $table->string('address');
            $table->char('whatsapp_num');
            $table->date('date');
            $table->string('location');
            $table->bigInteger('total_price');
            $table->enum('payment_status', ['Pending', 'Success', 'Expired', 'Canceled'])->default('Pending');
            $table->string('unicode', 16);
            $table->string('snap_token', 36)->nullable();
            $table->enum('order_status', ['On Going', 'On Working', 'Finished', 'Canceled'])->default('On Going');
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
        Schema::dropIfExists('orders');
    }
}
