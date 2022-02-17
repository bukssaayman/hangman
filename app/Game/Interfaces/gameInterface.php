<?php

namespace App\Game\Interfaces;

use App\Game\Model\GuessResultModel;

interface gameInterface {

    public function runGame(string $char): GuessResultModel;

    public function getRemainingGuessesLeftForWord(): int;

    public function getGameStatus(): string;

    public function getObfuscatedWord(): string;

    public function getWordDescription(): string;

    public function getRemainingCharsForGuessing(): array;
}
