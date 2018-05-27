<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestTeamPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_team', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('quest_id')->unique();
            $table->dateTime('assigned_at');
            $table->dateTime('completed_at')->nullable();
            $table->text('note')->nullable();
            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('quest_id')
                ->references('id')->on('quests')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('quest_team');
    }
}
