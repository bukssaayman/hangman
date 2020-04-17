<?php

namespace App\Game;

use App\Game\Model\GuessResultModel;
use App\Game\Interfaces\gameInterface;

class Game implements gameInterface {

    const GAME_STATUS_IN_PROGRESS = "in_progress";
    const GAME_STATUS_WON = "won_last_game";
    const GAME_STATUS_LOST = "lost_last_game";
    const GAME_GUESSES_PER_WORD_MULTIPLIER = 1.8;
    const WORD_OBFUSCATE_CHAR = 'x';

    private $totalGuessesForWord;
    private $totalGuessesLeftForWord;
    private $gameStatus;
    private $allowedChars;
    private $charsGuessed;
    private $charsNotYetGuessed;
    private $obfuscatedWord;
    private $randomWordObject;

    public function __construct(RandomWord $randomWord) {
        $this->randomWordObject = $randomWord;
        $this->runGame();
    }

    private function runGame() {
        $this->allowedChars = range('a', 'z');
        $this->totalGuessesForWord = ceil(strlen($this->randomWordObject->getRandomWordPlainText()) * self::GAME_GUESSES_PER_WORD_MULTIPLIER);
        $this->totalGuessesLeftForWord = ($this->totalGuessesForWord - count((array) $this->charsGuessed));
        $this->charsNotYetGuessed = array_diff($this->allowedChars, (array) $this->charsGuessed);
        $this->obfuscatedWord = str_replace($this->charsNotYetGuessed, self::WORD_OBFUSCATE_CHAR, $this->randomWordObject->getRandomWordPlainText());
        $unknownChars = substr_count($this->obfuscatedWord, self::WORD_OBFUSCATE_CHAR);

        $this->gameStatus = self::GAME_STATUS_IN_PROGRESS;
        if ($this->totalGuessesLeftForWord >= 0 && $unknownChars == 0) {
            $this->gameStatus = self::GAME_STATUS_WON;
        } else if ($this->totalGuessesLeftForWord == 0 && $unknownChars > 0) {
            $this->gameStatus = self::GAME_STATUS_LOST;
        }
    }

    public function makeGuess(String $char): GuessResultModel {
        $this->charsGuessed[] = $char;
        $this->runGame();
        return new GuessResultModel($this->obfuscatedWord, $this->totalGuessesLeftForWord, $this->gameStatus, $this->randomWordObject->getRandomWordPlainText());
    }

    public function getRemainingGuessesLeftForWord(): int {
        return $this->totalGuessesLeftForWord;
    }

    public function getGameStatus(): String {
        return $this->gameStatus;
    }

    public function getObfuscatedWord(): String {
        return $this->obfuscatedWord;
    }

    public function getWordDescription(): String {
        return $this->randomWordObject->getRandomWordDescription();
    }

    public function getRemainingCharsForGuessing(): array {
        return $this->charsNotYetGuessed;
    }

}
