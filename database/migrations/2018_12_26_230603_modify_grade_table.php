<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->smallInteger('order')->after('name')->default(0);
        });
        Schema::table('criteria', function (Blueprint $table) {
            $table->smallInteger('order')->after('name')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('order');
        });
        Schema::table('criteria', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}
