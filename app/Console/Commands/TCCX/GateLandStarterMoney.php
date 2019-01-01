<?php

namespace App\Console\Commands\TCCX;

use App\TCCX\GateLand\GateLandMoney;
use App\TCCX\Team;
use Illuminate\Console\Command;

class GateLandStarterMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tccx:gate-land-starter-money';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set initial money for GATE Land';

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
        $scoreData = app('TCCX\ScoreData');
        $data = $scoreData->generate();
        /** @var Team $team */
        foreach ($data['teams'] as $team) {
            if (!$team->money()->exists())
                $team->money()->save(new GateLandMoney());
            $team->money->money = $data['body'][$team->id]['sum'] ?? 0;
            $team->money->save();
        }
        $this->info('Starting money has been set for all team!');
        return 0;
    }
}
