<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyQuestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->smallInteger('time')->default(0)->after('name');
            $table->smallInteger('group')->default(0)->after('time');
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
            $table->dropColumn('time', 'group');
        });
    }
}
