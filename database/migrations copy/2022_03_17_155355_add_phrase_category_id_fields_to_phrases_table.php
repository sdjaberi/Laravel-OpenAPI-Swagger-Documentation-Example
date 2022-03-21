<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhraseCategoryIdFieldsToPhrasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phrases', function (Blueprint $table) {

            $table->unsignedInteger('phrase_category_id')->nullable();
            $table->foreign('phrase_category_id', 'phrase_category_fk_926910')->references('id')->on('phrase_categories')->onDelete('cascade');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phrases', function (Blueprint $table) {
            //
        });
    }
}
