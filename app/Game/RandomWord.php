<?php

namespace App\Game;

use App\Game\Interfaces\randomWordInterface;

class RandomWord implements randomWordInterface {

    private $randomWord;
    private $randomWordDescription;

    CONST RANDOM_WORD_URL = "https://randomword.com/";

    public function __construct() {
        do {
            $this->getRandomWord();
        } while (strlen($this->randomWord) < env('MIN_WORD_LEN', 5)); //no easy words
    }

    private function getRandomWord() {
        $doc = new \DOMDocument();
        $doc->loadHTMLFile(self::RANDOM_WORD_URL);

        $xpath = new \DOMXpath($doc);

        $this->randomWord = $this->xPathSearch($xpath->query("//*[@id='random_word']"));
        $this->randomWordDescription = $this->xPathSearch($xpath->query("//*[@id='random_word_definition']"));
    }

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

    public function getRandomWordPlainText(): String {
        return $this->randomWord;
    }

    public function getRandomWordDescription(): String {
        return $this->randomWordDescription;
    }

}
