<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->char('whatsapp_num');
            $table->date('date');
            $table->string('location');
            $table->enum('payment_status', ['Pending', 'Success', 'Expired', 'Canceled'])->default('Pending');
            $table->decimal('total_price', 19, 2);
            $table->string('unicode', 16);
            $table->enum('order_status', ['On Going', 'On Working', 'Finished', 'Canceled'])->default('On Going');
            $table->string('pricing_name');
            $table->string('pricing_type');
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
        Schema::dropIfExists('reports');
    }
}
