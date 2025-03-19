<?php

namespace VistarSvo\SimHash\Tokenizer;

interface Tokenizer
{
    public function tokenize(string $text): string;

    public function getSize(): int;
}
