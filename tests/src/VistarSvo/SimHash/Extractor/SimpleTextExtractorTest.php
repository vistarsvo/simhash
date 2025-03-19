<?php

namespace src\VistarSvo\SimHash\Extractor;

use PHPUnit\Framework\TestCase;
use VistarSvo\SimHash\Extractor\DefaultTextExtractor;

final class SimpleTextExtractorTest extends TestCase
{
    public function testExtract()
    {
        $extractor = new DefaultTextExtractor();

        self::assertEquals(
            [ 'mary', 'is', 'very', 'tall', 'she', 'was', 'in', 'the', '9th', 'grade' ],
            $extractor->extract('Mary is very tall. She was in the 9th grade.')
        );
    }
}
