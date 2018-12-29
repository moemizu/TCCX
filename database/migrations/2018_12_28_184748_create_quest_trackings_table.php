<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_trackings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id')->nullable();
            $table->smallInteger('assigned_group')->nullable();
            $table->unsignedInteger('current_quest_id')->nullable();
            $table->timestamps();
            $table->foreign('team_id')
                ->references('id')
                ->on('teams')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('current_quest_id')
                ->references('id')
                ->on('quests')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quest_trackings');
    }
}
