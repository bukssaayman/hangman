<?php

namespace App\Game\GameUtils;

use App\Game\Game;
use App\Game\RandomWordFromWebsite;

class GameFactory {

    /**
     * Factory design pattern. Return a new game.
     *
     * @return Game
     */
    public static function make(): Game {
        return new Game(new RandomWordFromWebsite());
    }
}
