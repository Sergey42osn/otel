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
            $table->string('name');
            $table->string('lastName');
            $table->string('email');
            $table->string('phone');
            $table->string('gender');
            $table->string('citizenship');
            $table->bigInteger('country_id');
            $table->bigInteger('city_id');
            $table->string('address');
            $table->string('postcode');
            $table->bigInteger('user_id');
            $table->bigInteger('object_id');
            $table->text('object_title');
            $table->bigInteger('room_id');
            $table->text('room_name');
            $table->date('data_booking');
            $table->string('check_in');
            $table->string('check_out');
            $table->integer('adults');
            $table->integer('children');
            $table->text('special_wishes');
            $table->integer('price');
            $table->string('payment');
            $table->text('policies');
            $table->text('canceled_message');
            $table->string('transaction_id');
            $table->integer('status');
            $table->string('channel_booking_number');
            $table->integer('channel_id');
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
