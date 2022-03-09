<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {

            $table->increments('id');

            $table->longText('translate_phrase')->nullable();

            $table->unsignedInteger('language_id');
            $table->foreign('language_id', 'language_fk_896910')->references('id')->on('languages')->onDelete('cascade');

            $table->unsignedInteger('phrase_id');
            $table->foreign('phrase_id', 'phrase_fk_896910')->references('id')->on('phrases')->onDelete('cascade');

            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_896910')->references('id')->on('users');

            //$table->unique(['translate_phrase', 'language_id']);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
