<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTeamRelationship
 * one to many relationship for Team and related model
 */
class CreateTeamRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->unsignedInteger('member_group_id')->nullable();
            $table->unsignedInteger('team_id')->nullable();
            $table->foreign('member_group_id')
                ->references('id')->on('member_groups')
                ->onDelete('set null');
            $table->foreign('team_id')
                ->references('id')->on('teams')
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
        Schema::table('members', function (Blueprint $table) {
            $index = ['team_id', 'member_group_id'];
            $table->dropForeign($index);
            $table->dropColumn($index);
        });
    }
}
