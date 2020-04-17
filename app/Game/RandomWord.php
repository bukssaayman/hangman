<?php

namespace App\Game;

use App\Game\Interfaces\RandomWordInterface;
//use App\Repository\Model\WordMol;

class RandomWord implements RandomWordInterface {

    public $randomWord;
    public $randomWordDescription;

    CONST RANDOM_WORD_URL = "https://randomword.com/";

    public function __construct() {
        do {
            $this->getRandomWord();
        } while (strlen($this->randomWord) < env('MIN_WORD_LEN')); //no easy words
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

}
