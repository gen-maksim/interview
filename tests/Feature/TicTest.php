<?php

namespace Tests\Feature;

use App\Models\TicField;
use App\Service\GameService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicTest extends TestCase
{

    /**
     * @var GameService
     */
    private $game;

    protected function setUp(): void
    {
        parent::setUp();

        $this->game = new GameService();
    }

    /** @test */
    public function it_has_empty_field()
    {
        $tic = new TicField();

        $this->assertEquals([
            ['', '', ''],
            ['', '', ''],
            ['', '', '']
        ], $tic->field);
    }

    /** @test */
    public function player_can_make_a_move()
    {
        $tic = new TicField();

        // 1 1
        $coordinates = [1, 1];

        $messasge = $this->game->recordMove($coordinates, $tic)['message'];

        $this->assertEquals([
            ['-', '', ''],
            ['', '+', ''],
            ['', '', '']
        ], $tic->field);
    }

    /** @test */
    public function player_cant_move_to_filled_cell()
    {
        $tic = new TicField();
        $tic->field = [
            ['', '', ''],
            ['', '+', '-'],
            ['', '', '']
        ];

        $coordinates = [1, 2];

        $this->game->recordMove($coordinates, $tic);

        $this->assertEquals([
            ['', '', ''],
            ['', '+', '-'],
            ['', '', '']
        ], $tic->field);
    }

    /** @test */
    public function player_can_win_a_game_in_rows()
    {
        $tic = new TicField();
        $tic->field = [
            ['', '', ''],
            ['+', '+', ''],
            ['', '', '']
        ];

        $coordinates = [1, 2];

        $result = $this->game->recordMove($coordinates, $tic);

        $this->assertEquals([
            ['', '', ''],
            ['+', '+', '+'],
            ['', '', '']
        ], $tic->field);

        $this->assertEquals('Game over)', $result['message']);
    }

    /** @test */
    public function player_can_win_a_game_in_columns()
    {
        $tic = new TicField();
        $tic->field = [
            ['', '+', ''],
            ['', '+', ''],
            ['', '', '']
        ];

        $coordinates = [2, 1];

        $result = $this->game->recordMove($coordinates, $tic);

        $this->assertEquals([
            ['', '+', ''],
            ['', '+', ''],
            ['', '+', '']
        ], $tic->field);

        $this->assertEquals('Game over)', $result['message']);
    }
    /** @test */
    public function player_can_win_a_game_in_diagonal()
    {
        $tic = new TicField();
        $tic->field = [
            ['', '', ''],
            ['', '+', ''],
            ['+', '', '']
        ];

        $coordinates = [0, 2];

        $result = $this->game->recordMove($coordinates, $tic);

        $this->assertEquals([
            ['', '', '+'],
            ['', '+', ''],
            ['+', '', '']
        ], $tic->field);

        $this->assertEquals('Game over)', $result['message']);
    }

    /** @test */
    public function system_cant_win()
    {
        $tic = new TicField();
        $tic->field = [
            ['-', '-', ''],
            ['', '+', ''],
            ['+', '', '']
        ];

        $coordinates = [2, 2];

        $result = $this->game->recordMove($coordinates, $tic);

        $this->assertEquals([
            ['-', '-', ''],
            ['-', '+', ''],
            ['+', '', '+']
        ], $tic->field);

        $this->assertNotEquals('Game over)', $result['message']);
    }
}
