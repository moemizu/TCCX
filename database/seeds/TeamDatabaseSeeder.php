<?php

use Illuminate\Database\Seeder;

class TeamDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Member group
        $masterGroup = \App\TCCX\MemberGroup::create([
            'name' => 'Master',
            'description' => 'Can do everything!'
        ]);
        $staffGroup = \App\TCCX\MemberGroup::create([
            'name' => 'Staff',
            'description' => 'Can access to basic administration task'
        ]);
        $memberGroup = \App\TCCX\MemberGroup::create([
            'name' => 'Member',
            'description' => 'Default group'
        ]);
        // Team
        // default member (aka: camp participant)
        factory(\App\TCCX\Team::class, 12)->create()->each(function ($team) use ($memberGroup) {
            /** @var \App\TCCX\Team $team */
            $members = factory(\App\TCCX\Member::class, 12)->create()->each(function ($member) use ($memberGroup) {
                /** @var \App\TCCX\Member $member */
                $memberGroup->members()->save($member);
            });
            $team->members()->saveMany($members);
        });
        // staff member
        factory(\App\TCCX\Member::class, 30)->create()->each(function ($member) use ($staffGroup) {
            /** @var \App\TCCX\Member $member */
            $staffGroup->members()->save($member);
        });
        // master member
        factory(\App\TCCX\Member::class, 20)->create()->each(function ($member) use ($masterGroup) {
            /** @var \App\TCCX\Member $member */
            $masterGroup->members()->save($member);
        });

    }
}
