<?php

namespace VistarSvo\SimHash\Factories;

final readonly class DefaultSimHashFactory implements SimHashFactory
{
    public function createSimHash(int $size = \VistarSvo\SimHash\Tokenizer\DefaultTokenizer::SIZE_256): \VistarSvo\SimHash\SimHash
    {
        return new \VistarSvo\SimHash\SimHash(
            new \VistarSvo\SimHash\Extractor\DefaultTextExtractor(),
            new \VistarSvo\SimHash\Tokenizer\DefaultTokenizer($size),
            new \VistarSvo\SimHash\Vectorizer\DefaultVectorizer(),
        );
    }
}
