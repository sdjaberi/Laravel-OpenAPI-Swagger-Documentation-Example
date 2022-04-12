<?php

use App\Enums\TranslationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('phrase_translations', function (Blueprint $table) {
            /** ENUM */
            $table->string('status')->default(TranslationStatus::Approved);
            /** end ENUM */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phrase_translations', function (Blueprint $table) {
            //
        });
    }
}
