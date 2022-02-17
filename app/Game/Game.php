<?php

namespace App\Game;

use App\Game\Model\GuessResultModel;
use App\Game\Interfaces\gameInterface;

class Game implements gameInterface {

    const GAME_STATUS_IN_PROGRESS = 'in_progress';

    const GAME_STATUS_WON = 'won_last_game';

    const GAME_STATUS_LOST = 'lost_last_game';

    /**
     * The idea here is simple. You get 1.8 times guesses per word.
     * Simple math: if a word is 10 chars, you get 18 guesses.
     */
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

    public function __construct(RandomWordFromWebsite $randomWord) {
        $this->randomWordObject = $randomWord;
        $this->runGame();
    }

    /**
     * All the inner workings of a game.
     *
     * @param String|null $char
     * @return GuessResultModel
     */
    public function runGame(String $char = null) : GuessResultModel {
        if (!is_null($char)) {
            $this->charsGuessed[] = $char;
        }

        $this->allowedChars = range('a', 'z');
        $this->totalGuessesForWord = ceil(strlen($this->randomWordObject->getRandomWordPlainText()) * self::GAME_GUESSES_PER_WORD_MULTIPLIER);
        $this->totalGuessesLeftForWord = ($this->totalGuessesForWord - count((array) $this->charsGuessed));
        $this->charsNotYetGuessed = array_diff($this->allowedChars, (array) $this->charsGuessed);
        $this->obfuscatedWord = str_replace($this->charsNotYetGuessed, self::WORD_OBFUSCATE_CHAR, $this->randomWordObject->getRandomWordPlainText());
        $unknownChars = substr_count($this->obfuscatedWord, self::WORD_OBFUSCATE_CHAR);

        $this->gameStatus = self::GAME_STATUS_IN_PROGRESS;
        if ($this->totalGuessesLeftForWord >= 0 && $unknownChars == 0) { // You guessed all the chars in your alotted guesses.
            $this->gameStatus = self::GAME_STATUS_WON;
        } else if ($this->totalGuessesLeftForWord == 0 && $unknownChars > 0) { // You used up all your guesses and still have unknown chars.
            $this->gameStatus = self::GAME_STATUS_LOST;
        }

        return new GuessResultModel($this->obfuscatedWord, $this->totalGuessesLeftForWord, $this->gameStatus, $this->randomWordObject->getRandomWordPlainText());
    }

    /**
     * Get the remaining amount of guesses for the word.
     *
     * @return integer
     */
    public function getRemainingGuessesLeftForWord(): int {
        return $this->totalGuessesLeftForWord;
    }

    /**
     * Get the current game's status.
     *
     * @return String
     */
    public function getGameStatus(): String {
        return $this->gameStatus;
    }

    /**
     * Get the current game's obfuscated word.
     *
     * @return String
     */
    public function getObfuscatedWord(): String {
        return $this->obfuscatedWord;
    }

    /**
     * Get the current game's word description.
     *
     * @return String
     */
    public function getWordDescription(): String {
        return $this->randomWordObject->getRandomWordDescription();
    }

    /**
     * Get the current games's remaining chars that have not been guessed.
     *
     * @return array
     */
    public function getRemainingCharsForGuessing(): array {
        return $this->charsNotYetGuessed;
    }

}
