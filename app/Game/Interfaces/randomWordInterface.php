<?php

namespace App\Game\Interfaces;

interface randomWordInterface {

    public function getRandomWordPlainText(): string;

    public function getRandomWordDescription(): string;
}
