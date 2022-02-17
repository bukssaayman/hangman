<?php

namespace App\Game;

use App\Game\Interfaces\randomWordInterface;

class RandomWordFromWebsite implements randomWordInterface {

    private $randomWord;
    private $randomWordDescription;

    CONST RANDOM_WORD_URL = 'https://randomword.com/';

    public function __construct() {
        do {
            $this->getRandomWord();
        } while (strlen($this->randomWord) < env('MIN_WORD_LEN', 5)); // No easy words.
    }

    /**
     * Bootstrap for getting the random word.
     *
     * @return void
     */
    private function getRandomWord() {
        $doc = new \DOMDocument();
        $doc->loadHTMLFile(self::RANDOM_WORD_URL);

        $xpath = new \DOMXpath($doc);

        $this->randomWord = $this->xPathSearch($xpath->query("//*[@id='random_word']"));
        $this->randomWordDescription = $this->xPathSearch($xpath->query("//*[@id='random_word_definition']"));
    }

    /**
     * Look for the specific node.
     *
     * @param [type] $xpathExpression
     * @return String
     */
    private function xPathSearch($xpathExpression): String {
        if (!is_null($xpathExpression)) {
            foreach ($xpathExpression as $element) {
                $nodes = $element->childNodes;
                foreach ($nodes as $node) {
                    return $node->nodeValue;
                }
            }
        }
    }

    /**
     * Get the plain text value for the random word.
     *
     * @return String
     */
    public function getRandomWordPlainText(): string {
        return $this->randomWord;
    }

    /**
     * Get the description for the random word.
     *
     * @return String
     */
    public function getRandomWordDescription(): string {
        return $this->randomWordDescription;
    }

}
