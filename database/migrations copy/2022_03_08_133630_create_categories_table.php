<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {

            //$table->increments('id');

            $table->string('name')->primary();

            $table->longText('description')->nullable();

            $table->unsignedInteger('project_id')->nullable();
            $table->foreign('project_id', 'project_fk_896888')->references('id')->on('projects');

            $table->string('icon')->nullable();

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
        Schema::dropIfExists('categories');
    }
}
