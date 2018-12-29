<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyQuestTrackingsTableAddItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quest_trackings', function (Blueprint $table) {
            $table->unsignedInteger('item_id')->nullable()->after('assigned_group');
            $table->foreign('item_id')
                ->references('id')
                ->on('quest_items')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quest_trackings', function (Blueprint $table) {
            $table->dropForeign('item_id');
            $table->dropColumn('item_id');
        });
    }
}
