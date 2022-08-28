<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyCategoryIdColumnToPostsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts_category', function (Blueprint $table) {
            $table->foreign("category_id")->references("id")->on("category");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts_category', function (Blueprint $table) {
            $table->dropForeign(["category_id"]);
        });
    }
}
