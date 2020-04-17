<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Game\RandomWord;

class RandomWordTest extends TestCase {

    /**
     * Test that the random word generator does return a class of type "RandomWord"
     */
    public function testBasicTest() {
        $randomWord = new RandomWord();
        $this->assertInstanceOf(RandomWord::class, $randomWord);
    }

}
