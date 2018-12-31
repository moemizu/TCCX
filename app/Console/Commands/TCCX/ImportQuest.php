<?php

namespace App\Console\Commands\TCCX;

use App\TCCX\Quest\Quest;
use App\TCCX\Quest\QuestLocation;
use App\TCCX\Quest\QuestType;
use App\TCCX\Quest\QuestZone;
use Illuminate\Console\Command;

class ImportQuest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tccx:import-quest {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import new quest';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');
        try {
            $rawData = array_map('str_getcsv', file(storage_path($file)));
        } catch (\Exception $e) {
            $this->error('Problem while reading a file!');
            return 1;
        }
        if (empty($rawData)) {
            $this->error('File is empty!');
            return 1;
        }
        // prepare
        // Parsing (index sorted in ascending order)
        // Final Order,Time,Zone,Type,Line,
        // Item,Level,Name,Location,No.Staff,
        // Material.Req,Background,Target,Solution,Criterion
        for ($i = 1; $i < count($rawData); $i++) {
            $rawQuest = $rawData[$i];
            $quest = new Quest();
            // basic
            $quest->name = $rawQuest[7];
            $quest->time = strtoupper($rawQuest[1]);
            $quest->group = $rawQuest[4];
            $quest->order = (int)$rawQuest[5];
            $quest->difficulty = (int)$rawQuest[6];
            $quest->multiple_team = 0;
            // content
            $quest->story = $rawQuest[11];
            $quest->how_to = $rawQuest[13];
            $quest->target = $rawQuest[12];
            $quest->material = $rawQuest[10];
            $quest->criteria = $rawQuest[14];
            // reward
            if ($rawQuest[3] == 'M')
                $quest->reward = 200;
            else
                $quest->reward = $quest->difficulty * 100;
            // type and zone
            $quest->quest_zone()->associate(QuestZone::whereCode($rawQuest[2])->first());
            $quest->quest_type()->associate(QuestType::whereCode($rawQuest[3])->first());
            // location
            $locationName = trim($rawQuest[8]);
            if (!empty($locationName) && !in_array($locationName, ['N/A', '?'])) {
                $location = QuestLocation::firstOrCreate([
                    'name' => $locationName], ['lat' => 0.0, 'lng' => 0.0, 'type' => ''
                ]);
                $location->save();
                $quest->quest_location()->associate($location);
            }
            $quest->save();
            $this->info('Quest ' . $rawQuest[0] . ' created!');
        }
        $this->info('Import success!');
        return 0;
    }
}
