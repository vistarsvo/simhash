<?php

namespace VistarSvo\SimHash\Vectorizer;

interface Vectorizer
{
    /**
     * @param array<string> $tokens
     * @param int $size
     * @return array
     */
    public function vectorize(array $tokens, int $size): array;
}
