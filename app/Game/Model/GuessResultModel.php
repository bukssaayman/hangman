<?php

namespace App\Game\Model;

class GuessResultModel {

    private $obfuscatedWord;
    private $guessesRemaining;
    private $gameStatus;
    private $word;

    public function __construct(String $obfuscatedWord, int $guessesRemaining, String $gameStatus, String $word) {
        $this->obfuscatedWord = $obfuscatedWord;
        $this->guessesRemaining = $guessesRemaining;
        $this->gameStatus = $gameStatus;
        $this->word = $word;
    }

    public function getStatus(): String {
        return $this->gameStatus;
    }

    public function getPlainTextWord() {
        return $this->word;
    }

    public function getWord(): String {
        return $this->obfuscatedWord;
    }

    public function getRemainingGuesses(): int {
        return $this->guessesRemaining;
    }

}
