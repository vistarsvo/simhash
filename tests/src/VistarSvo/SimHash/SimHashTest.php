<?php

namespace src\VistarSvo\SimHash;

use PHPUnit\Framework\TestCase;
use VistarSvo\SimHash\Comparator\GaussianComparator;
use VistarSvo\SimHash\Extractor\DefaultTextExtractor;
use VistarSvo\SimHash\SimHash;
use VistarSvo\SimHash\Tokenizer\DefaultTokenizer;
use VistarSvo\SimHash\Vectorizer\DefaultVectorizer;

final class SimHashTest extends TestCase
{
    public function testDifferentTexts()
    {
        $text1 = file_get_contents(__DIR__ . '/../../../resources/text/file1.txt');
        $text2 = file_get_contents(__DIR__ . '/../../../resources/text/file3.txt');

        $simHash = new SimHash(
            extractor: new DefaultTextExtractor(),
            tokenizer: new DefaultTokenizer(DefaultTokenizer::SIZE_64),
            vectorizer: new DefaultVectorizer(),
        );
        $comparator = new GaussianComparator();

        $fp1 = $simHash->makeHash($text1);
        $fp2 = $simHash->makeHash($text2);

        self::assertLessThan(0.1, $comparator->compare($fp1, $fp2));
    }

    public function testSimilarTexts()
    {
        $text1 = file_get_contents(__DIR__ . '/../../../resources/text/file1.txt');
        $text2 = file_get_contents(__DIR__ . '/../../../resources/text/file2.txt');

        $simHash = new SimHash(
            extractor: new DefaultTextExtractor(),
            tokenizer: new DefaultTokenizer(DefaultTokenizer::SIZE_64),
            vectorizer: new DefaultVectorizer(),
        );
        $comparator = new GaussianComparator();

        $fp1 = $simHash->makeHash($text1);
        $fp2 = $simHash->makeHash($text2);

        self::assertLessThan(0.9, $comparator->compare($fp1, $fp2));
        self::assertGreaterThan(0.1, $comparator->compare($fp1, $fp2));
    }

    public function testEqualTexts()
    {
        $text1 = file_get_contents(__DIR__ . '/../../../resources/text/file1.txt');
        $text2 = file_get_contents(__DIR__ . '/../../../resources/text/file1.txt');

        $simHash = new SimHash(
            extractor: new DefaultTextExtractor(),
            tokenizer: new DefaultTokenizer(DefaultTokenizer::SIZE_64),
            vectorizer: new DefaultVectorizer(),
        );
        $comparator = new GaussianComparator();

        $fp1 = $simHash->makeHash($text1);
        $fp2 = $simHash->makeHash($text2);

        self::assertEquals(1, $comparator->compare($fp1, $fp2));
    }
}
