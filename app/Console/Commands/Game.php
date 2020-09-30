<?php

namespace App\Console\Commands;

use App\Models\TicField;
use App\Service\GameService;
use Illuminate\Console\Command;

class Game extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:play {row} {column}';

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
        $tic = TicField::firstOrNew();
        $game = new GameService();

        $result = $game->recordMove([$this->argument('row'), $this->argument('column')], $tic);

        foreach ($tic->field as $row) {
            $this->info(implode('|' , $row));
        }

        $this->info($result['message']);

        return 0;
    }
}
