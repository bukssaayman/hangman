<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game\GameUtils\{
    Storage,
    GameFactory
};

class PlayController extends Controller {

    /**
     * Bootstrap for a new game.
     *
     * @return void
     */
    public function play() {
        $hangmanGame = Storage::retrieve();
        Storage::save($hangmanGame);

        return view('hangman', [
            'word' => $hangmanGame->getObfuscatedWord(),
            'description' => $hangmanGame->getWordDescription(),
            'remainingGuesses' => $hangmanGame->getRemainingGuessesLeftForWord(),
            'remaingChars' => $hangmanGame->getRemainingCharsForGuessing()
        ]);
    }

    /**
     * Return for an ajax request.
     *
     * @param Request $request
     * @return void
     */
    public function ajaxGuessCharPost(Request $request) {
        $hangmanGame = Storage::retrieve();
        $input = $request->all();
        $gameResults = $hangmanGame->runGame($input['char']);
        Storage::save($hangmanGame);

        return response()->json([
            'word' => $gameResults->getWord(),
            'remainingGuesses' => $gameResults->getRemainingGuesses(),
            'gameStatus' => $gameResults->getStatus(),
            'youFoundTheSecretEasterEgg' => $gameResults->getPlainTextWord()
        ]);
    }

    /**
     * This gets you a new game.
     *
     * @return void
     */
    public function reset() {
        Storage::save(GameFactory::make());

        return back();
    }
}
