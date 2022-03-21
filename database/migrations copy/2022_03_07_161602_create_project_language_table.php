<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLangprojectLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_language', function (Blueprint $table) {
            $table->unsignedInteger('project_id');

            $table->foreign('project_id', 'project_id_fk_896875')->references('id')->on('projects')->onDelete('cascade');

            $table->unsignedInteger('language_id');

            $table->foreign('language_id', 'language_id_fk_896875')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_language');
    }
}
