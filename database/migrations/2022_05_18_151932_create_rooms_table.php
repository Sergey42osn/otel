<?php

use App\Models\Type;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('roomable_id');
            $table->string('roomable_type');
            $table->string('title')->nullable();
            $table->bigInteger('number');
            $table->float('price');
            $table->float('size')->nullable();
            $table->foreignIdFor(Type::class);
            $table->integer('single_bed')->nullable();
            $table->integer('double_bed')->nullable();
            $table->integer('sofa_bed')->nullable();
            $table->integer('wide_bed')->nullable();
            $table->integer('futon')->nullable();
            $table->integer('guest_count')->nullable();
            $table->boolean('extra_beds')->default(false);
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
        Schema::dropIfExists('rooms');
    }
}
