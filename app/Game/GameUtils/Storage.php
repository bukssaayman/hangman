<?php

namespace App\Game\GameUtils;

use App\Game\GameUtils\GameFactory;
use App\Game\Game;
use Session;

class Storage {
    public static function retrieve() {
        return \Session::get(Game::class, GameFactory::make());
    }

    public static function save(Game $game) {
        session()->put(Game::class, $game);
        session()->save();
    }
}
