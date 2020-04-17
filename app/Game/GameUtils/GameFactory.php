<?php

namespace App\Game\GameUtils;

use App\Game\RandomWord;
use App\Game\Game;

/**
 * Description of GameFactory
 *
 * @author bukss
 */
class GameFactory {
     public static function make()
    {
        return new Game(new RandomWord());
    }
}
