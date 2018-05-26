<?php

use Illuminate\Database\Seeder;

class QuestTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('quest_types');
        $table->insert([
            'name' => 'Main',
            'code' => 'M',
            'description' => 'Main quest description'
        ]);
        $table->insert([
            'name' => 'Side',
            'code' => 'S',
            'description' => 'Side quest description'
        ]);
        $table->insert([
            'name' => 'Lunch',
            'code' => 'L',
            'description' => 'Lunch quest description'
        ]);
        $table->insert([
            'name' => 'Contest',
            'code' => 'C',
            'description' => 'Contest quest description'
        ]);
    }
}
