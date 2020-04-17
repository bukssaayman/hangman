<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game\GameUtils\{
    Storage,
    GameFactory
};

class PlayController extends Controller {

    public function __construct() {
        //nothing for now
    }

    public function index(Request $request) {
        $hangmanGame = Storage::retrieve();
        Storage::save($hangmanGame);

        return view('hangman', [
            'word' => $hangmanGame->getObfuscatedWord(),
            'description' => $hangmanGame->getWordDescription(),
            'remainingGuesses' => $hangmanGame->getRemainingGuessesLeftForWord(),
            'remaingChars' => $hangmanGame->getRemainingCharsForGuessing()
        ]);
    }

    public function ajaxGuessCharPost(Request $request) {
        $hangmanGame = Storage::retrieve();
        $input = $request->all();
        $gameResults = $hangmanGame->makeGuess($input['char']);
        Storage::save($hangmanGame);
        return response()->json([
                    'word' => $gameResults->getWord(),
                    'remainingGuesses' => $gameResults->getRemainingGuesses(),
                    'gameStatus' => $gameResults->getStatus(),
                    'plainTextWord' => $gameResults->getPlainTextWord()
        ]);
    }

    public function reset() {
        Storage::save(GameFactory::make());
        return back();
    }

}
