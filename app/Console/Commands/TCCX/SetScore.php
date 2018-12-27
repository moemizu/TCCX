<?php

namespace App\Console\Commands\TCCX;

use App\TCCX\Subject;
use App\TCCX\Team;
use Illuminate\Console\Command;

class SetScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tccx:set-score {team} {subject} {criterion} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set score for specific team';

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
        $teamArg = $this->argument('team');
        $team = Team::where('name', $teamArg)->orWhere('id', $teamArg)->firstOrFail();
        $subjectArg = $this->argument('subject');
        $subject = Subject::where('name', $subjectArg)->orWhere('id', $subjectArg)->firstOrFail();
        $criterionArg = $this->argument('criterion');
        $criterion = $subject->criteria()->where('name', $criterionArg)->orWhere('id', $criterionArg)->firstOrFail();
        $value = (int)$this->argument('value');
        if ($team->criteria->contains($criterion->id)) {
            $team->criteria()->updateExistingPivot($criterion, ['value' => $value]);
        } else {
            $team->criteria()->attach($criterion, ['value' => $value]);
        }
        $this->info('Score has been updated!');
        return 0;
    }
}
