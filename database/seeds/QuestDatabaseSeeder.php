<?php

use Illuminate\Database\Seeder;
use App\TCCX\Quest\{
    Quest, QuestLocation, QuestType, QuestZone
};

class QuestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Quest sub model
        $this->call([QuestTypesTableSeeder::class, QuestZonesTableSeeder::class]);
        $types = QuestType::all();
        $zones = QuestZone::all();
        $locations = factory(QuestLocation::class, 100)->create();
        $self = $this;
        // Quest main model
        $this->command->info('Creating Quest...');
        factory(Quest::class, 100)->create()->each(function ($quest) use ($self, $zones, $types, $locations) {
            /** @var Quest $quest */
            $quest->questLocation()->associate($locations->random());
            $quest->questType()->associate($types->random());
            $quest->questZone()->associate($zones->random());
            $quest->save();
        });
    }
}
