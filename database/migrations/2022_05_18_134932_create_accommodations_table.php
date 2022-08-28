<?php

use App\Models\Country;
use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 20);
            $table->float('price', 10, 0)->nullable();
            $table->boolean('sales_channel')->nullable()->default(false);
            $table->bigInteger('accommodationable_id');
            $table->string('accommodationable_type');
            $table->text('description')->nullable();
            $table->boolean('extra_beds')->nullable();
            $table->text('agree_terms');
            $table->text('certify_terms');
            $table->boolean('allow_pets');
            $table->boolean('allow_child');
            $table->text('child_policy')->nullable();
            $table->foreignIdFor(Country::class);
            $table->foreignIdFor(City::class);
            $table->text("other_rules")->nullable();
            $table->string('protection_booking')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('alt_phone')->nullable();
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
        Schema::dropIfExists('accomodations');
    }
}
