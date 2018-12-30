<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'manage_scoreboard'], ['name' => 'manage_quest']
        ];
        foreach ($permissions as $permission) {
            \App\Permission::firstOrNew($permission)->save();
        }
    }
}
