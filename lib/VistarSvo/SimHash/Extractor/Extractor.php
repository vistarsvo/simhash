<?php

namespace VistarSvo\SimHash\Extractor;

interface Extractor
{
    public function extract(mixed $input): array;
}
