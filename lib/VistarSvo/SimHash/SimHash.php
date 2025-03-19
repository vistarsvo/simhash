<?php

namespace VistarSvo\SimHash;

use VistarSvo\SimHash\Extractor\Extractor;
use VistarSvo\SimHash\Tokenizer\Tokenizer;
use VistarSvo\SimHash\Vectorizer\Vectorizer;

final readonly class SimHash
{
    public function __construct(
        private Extractor $extractor,
        private Tokenizer $tokenizer,
        private Vectorizer $vectorizer,
    ) { }

    public function makeHash(mixed $input): Fingerprint
    {
        $words = $this->extractor->extract($input);
        $tokens = [];
        foreach ($words as $word) {
            $tokens[] = $this->tokenizer->tokenize($word);
        }

        $vector = $this->vectorizer->vectorize($tokens, $this->tokenizer->getSize());
        $binaryData = '';
        for ($i = 0; $i < $this->tokenizer->getSize(); $i++) {
            $binaryData .= $vector[$i] > 0 ? '1' : '0';
        }

        return new Fingerprint($this->tokenizer->getSize(), $binaryData);
    }
}
