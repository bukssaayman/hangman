<?php

namespace App\Game\Interfaces;

interface randomWordInterface {

    public function getRandomWordPlainText(): String;

    public function getRandomWordDescription(): String;
}
