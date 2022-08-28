<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerShipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_ships', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('personal_information');
            $table->integer('security');
            $table->integer('booking_and_reports');
            $table->integer('reviews');
            $table->integer('my_objects');
            $table->integer('finance_documents');
            $table->integer('partners');
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
        Schema::dropIfExists('partner_ships');
    }
}
