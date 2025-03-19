<?php

namespace src\VistarSvo\SimHash\Tokenizer;

use PHPUnit\Framework\TestCase;
use VistarSvo\SimHash\Tokenizer\DefaultTokenizer;

final class TokenizerTest extends TestCase
{
    public function testTokenize32(): void
    {
        $this->setName('testTokenize32');

        $tokenize = new DefaultTokenizer(32);
        $tokenizeResult = $tokenize->tokenize("Mary is very tall. She was in the 9th grade.");
        $result = '01100010110110001010101100111101';

        self::assertIsString($tokenizeResult, "Tokenize is not a string");
        self::assertEquals($tokenizeResult, $result, "Tokenize is not equal to the expected result");
    }

    public function testTokenize64(): void
    {
        $this->setName('testTokenize64');

        $tokenize = new DefaultTokenizer(64);
        $tokenizeResult = $tokenize->tokenize("Mary is very tall. She was in the 9th grade.");
        $result = '0011001001101111000000000001010101001000010001110110011000000110';

        self::assertIsString($tokenizeResult, "Tokenize is not a string");
        self::assertEquals($tokenizeResult, $result, "Tokenize is not equal to the expected result");
    }

    public function testTokenize128(): void
    {
        $this->setName('testTokenize128');

        $tokenize = new DefaultTokenizer(128);
        $tokenizeResult = $tokenize->tokenize("Mary is very tall. She was in the 9th grade.");
        $result = '00011001001101100000001000001000101000001100001001000111011001110111111001110000011000110000001001101100111010100110100110010001';

        self::assertIsString($tokenizeResult, "Tokenize is not a string");
        self::assertEquals($tokenizeResult, $result, "Tokenize is not equal to the expected result");
    }

    public function testTokenize1024(): void
    {
        $this->setName('testTokenize1024');

        $tokenize = new DefaultTokenizer(1024);
        $tokenizeResult = $tokenize->tokenize("Mary is very tall. She was in the 9th grade.");
        $result = '0100010100000111010111111110100101010010000100000111011011001101101100111011001110000000101010001100111000100011000001001101101000100101100100011001000110110111100111001010010111010000001010001000001011100000111111010000011000111010101011111000110111001001010010010011110010000000011000111010001110111010100101001001011110100110011110010001011100101000110010100011000010101000111100010000111111010001110010101001010010010000010110001111101111001001111011000001111111101100000100010111001011110011011110000110101100011101011001001001000000011001111111100001101100101111100100000100000010100101000000011110010000110010001010000111001001011000001000000001011101110010000111100100000111000100100000111001110101101100110111011010110100001111011100010100101010011010100111011000010000100011110111101110100001110101011011111010000010011011101000110110011001011001101110110111000010000110011010001010011000000111101011101011101110101011111111110000001111111110101000101010111001110000110111010100001000001101000011000111110110110111';

        self::assertIsString($tokenizeResult, "Tokenize is not a string");
        self::assertEquals($tokenizeResult, $result, "Tokenize is not equal to the expected result");
    }
}
