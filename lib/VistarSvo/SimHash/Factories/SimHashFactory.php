<?php

namespace VistarSvo\SimHash\Factories;

interface SimHashFactory
{
    public function createSimHash(int $size): \VistarSvo\SimHash\SimHash;
}
