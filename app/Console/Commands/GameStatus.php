<?php

namespace App\Console\Commands;

use App\Models\TicField;
use App\Service\GameService;
use Illuminate\Console\Command;

class GameStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $tic = TicField::first();
        $game = new GameService();

        if (!$tic) {
            $this->info('game is not started');
            $this->info('use game:play {row} {column} to play');
        } else {
            $this->info('there is a game in process');
            foreach ($tic->field as $row) {
                $this->info(implode('|' , $row));
            }
            $this->info('use game:new to start new');
        }

        return 0;
    }
}
