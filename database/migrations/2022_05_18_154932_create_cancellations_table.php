<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancellationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancellations', function (Blueprint $table) {
            $table->id();
            $table->string('titile');
            $table->string('text');
            $table->longText('rand_booking_info');
            $table->boolean('switch');
            $table->text('period_without_penalty');
            $table->text('period_with_payment');
            $table->text('cancel_info');
            $table->bigInteger('protection_booking');
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
        Schema::dropIfExists('cancellations');
    }
}
