<?php

namespace App\Game\GameUtils;

use App\Game\GameUtils\GameFactory;
use App\Game\Game;

class Storage {

   /**
    * Get the current game in the session.
    *
    * @return Game
    */
    public static function retrieve(): Game {
        return session()->get(Game::class, GameFactory::make());
    }

    /**
     * Save the current game to the session.
     *
     * @param Game $game
     * @return void
     */
    public static function save(Game $game): void {
        session()->put(Game::class, $game);
        session()->save();
    }
}
