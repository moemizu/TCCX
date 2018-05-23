<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Quest model with foreign key
        Schema::table('quests', function (Blueprint $table) {
            // Allow some quest to have no fixed location or zone
            $table->unsignedInteger('quest_location_id')->nullable()->after('name');
            $table->unsignedInteger('quest_zone_id')->nullable()->after('name');
            $table->unsignedInteger('quest_type_id')->after('name');
            $table->foreign('quest_location_id')
                ->references('id')->on('quest_locations')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('quest_zone_id')
                ->references('id')->on('quest_zones')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('quest_type_id')
                ->references('id')->on('quest_types')
                ->onDelete('cascade')
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
        // Drop Quest model
        Schema::table('quests', function (Blueprint $table) {
            $columns = ['quest_location_id', 'quest_zone_id', 'quest_type_id'];
            $table->dropForeign($columns);
            $table->dropColumn($columns);
        });
    }
}
