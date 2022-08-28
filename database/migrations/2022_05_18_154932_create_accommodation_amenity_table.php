<?php

use App\Models\Accommodation;
use App\Models\Amenity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationAmenityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_amenity', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Accommodation::class);
            $table->foreignIdFor(Amenity::class);
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
        Schema::dropIfExists('accommodation_amenity');
    }
}
