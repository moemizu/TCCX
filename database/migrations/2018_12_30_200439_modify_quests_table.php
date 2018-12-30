<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyQuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->text('story')->nullable()->change();
            $table->text('how_to')->nullable()->change();
            $table->text('criteria')->nullable()->change();
            $table->text('meta')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->text('story')->change();
            $table->text('how_to')->change();
            $table->text('criteria')->change();
            $table->text('meta')->change();
        });
    }
}
