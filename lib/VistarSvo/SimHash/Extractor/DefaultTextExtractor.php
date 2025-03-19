<?php

namespace VistarSvo\SimHash\Extractor;

final class DefaultTextExtractor implements Extractor
{
    public function extract(mixed $input): array
    {
        $input = strtolower($input);
        $input = preg_replace('/[^a-z0-9]/', ' ', $input);
        $input = preg_replace('/\s+/', ' ', $input);

        return explode(' ', $input);
    }
}
