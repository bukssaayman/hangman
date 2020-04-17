<?php

namespace App\Game\Interfaces;

use App\Game\Model\GuessResultModel;

interface gameInterface {

    public function makeGuess(String $char): GuessResultModel;

    public function getRemainingGuessesLeftForWord(): int;

    public function getGameStatus(): String;

    public function getObfuscatedWord(): String;

    public function getWordDescription(): String;

    public function getRemainingCharsForGuessing(): array;
}
