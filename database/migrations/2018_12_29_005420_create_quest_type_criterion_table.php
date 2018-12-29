<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestTypeCriterionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_type_criterion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quest_type_id');
            $table->smallInteger('time');
            $table->unsignedInteger('criterion_id')->nullable();
            $table->foreign('quest_type_id')
                ->references('id')
                ->on('quest_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('criterion_id')
                ->references('id')
                ->on('criteria')
                ->onDelete('set null')
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
        Schema::dropIfExists('quest_type_criterion');
    }
}
