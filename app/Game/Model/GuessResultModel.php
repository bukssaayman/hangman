<?php

namespace App\Game\Model;

class GuessResultModel {

    private $obfuscatedWord;
    private $guessesRemaining;
    private $gameStatus;
    private $word;

    public function __construct(string $obfuscatedWord, int $guessesRemaining, string $gameStatus, string $word) {
        $this->obfuscatedWord = $obfuscatedWord;
        $this->guessesRemaining = $guessesRemaining;
        $this->gameStatus = $gameStatus;
        $this->word = $word;
    }

    /**
     * Returns the status of a game.
     *
     * @return String
     */
    public function getStatus(): string {
        return $this->gameStatus;
    }

    /**
     * Super secret cheat method :-)
     *
     * @return void
     */
    public function getPlainTextWord() {
        return $this->word;
    }

    /**
     * Returns the obfuscated word.
     *
     * @return String
     */
    public function getWord(): string {
        return $this->obfuscatedWord;
    }

    /**
     * Returns the amount of remaining guesses.
     *
     * @return integer
     */
    public function getRemainingGuesses(): int {
        return $this->guessesRemaining;
    }

}
