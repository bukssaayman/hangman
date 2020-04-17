<?php

namespace App\Game\GameUtils;

use App\Game\GameUtils\GameFactory;
use App\Game\Game;
use Session;

class Storage {

    /**
     * You'll notice some inconsistency in how I use the session helpers and library
     * None of the Laravel docs examples worked for me. Either I set the session and 
     * it just 'disappears' or it doesn't set at all.  This is the only combination
     * I found to actually work.  I'll fix this up later.
     */
    public static function retrieve() {
        return \Session::get(Game::class, GameFactory::make());
    }

    public static function save(Game $game) {
        session()->put(Game::class, $game);
        session()->save();
    }

}
