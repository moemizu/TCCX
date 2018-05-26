<?php

use Illuminate\Database\Seeder;

class QuestZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('quest_zones');
        $table->insert([
            'name' => 'Siam',
            'code' => 'S',
            'description' => 'Siam zone'
        ]);
        $table->insert([
            'name' => 'Rattanakosin',
            'code' => 'R',
            'description' => 'Rattanakosin zone'
        ]);
    }
}
