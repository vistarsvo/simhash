<?php

namespace VistarSvo\SimHash\Tokenizer;

final class DefaultTokenizer implements Tokenizer
{
    public const int SIZE_32 = 32;
    public const int SIZE_64 = 64;
    public const int SIZE_128 = 128;
    public const int SIZE_256 = 256;
    public const int SIZE_384 = 384;
    public const int SIZE_512 = 512;
    public const int SIZE_768 = 768;
    public const int SIZE_1024 = 1024;

    private static array $crc64Table = [];

    public function __construct(public readonly int $size = self::SIZE_256)
    {
        $array = [self::SIZE_32, self::SIZE_64, self::SIZE_128, self::SIZE_256, self::SIZE_384, self::SIZE_512, self::SIZE_768, self::SIZE_1024];
        if (!in_array($this->size, $array)) {
            throw new \InvalidArgumentException('Invalid size. Must be one of: ' . implode(', ', $array));
        }
    }

    public function tokenize(string $text): string
    {
        return match($this->size) {
            self::SIZE_32 => $this->hashCrc32($text),
            self::SIZE_64 => $this->hashCrc64($text),
            self::SIZE_128 => $this->hashMd5($text),
            self::SIZE_256 => $this->hashSha256($text),
            self::SIZE_384 => $this->hashSha384($text),
            self::SIZE_512 => $this->hashSha512($text),
            self::SIZE_768 => $this->hashSha512($text) . $this->hashSha256($text),
            self::SIZE_1024 => $this->hashSha512($text) . $this->hashSha512(strrev($text)),
            default => throw new \InvalidArgumentException('Unsupported size'),
        };
    }

    public function getSize(): int
    {
        return $this->size;
    }

    private function hashCrc32(string $text): string
    {
        return str_pad(base_convert(hash('crc32b', $text), 16, 2), 32, '0', STR_PAD_LEFT);
    }

    private function hashCrc64(string $text): string
    {
        return str_pad(base_convert($this->crc64($text), 16, 2), 64, '0', STR_PAD_LEFT);
    }

    private function hashMd5(string $text): string
    {
        return $this->hashToSize(hash('md5', $text));
    }

    private function hashSha256(string $text): string
    {
        return $this->hashToSize(hash('sha256', $text));
    }

    private function hashSha384(string $text): string
    {
        return $this->hashToSize(hash('sha384', $text));
    }

    private function hashSha512(string $text): string
    {
        return $this->hashToSize(hash('sha512', $text));
    }

    private function hashToSize(string $hash): string
    {
        $binary = '';
        for ($i = 0; $i < strlen($hash); $i++) {
            $binary .= str_pad(base_convert($hash[$i], 16, 2), 4, '0', STR_PAD_LEFT);
        }

        return $binary;
    }

    private function crc64(string $string): string
    {
        if (empty(self::$crc64Table)) {
            self::$crc64Table = $this->buildTable();
        }

        $crc = 0;
        $length = strlen($string);

        for ($i = 0; $i < $length; $i++) {
            $crc = self::$crc64Table[($crc ^ ord($string[$i])) & 0xff] ^ (($crc >> 8) & ~(0xff << 56));
        }

        return sprintf('%x', $crc);
    }

    private function buildTable(): array
    {
        $crc64tab = [];
        $poly64rev = (0xC96C5795 << 32) | 0xD7870F42; // ECMA polynomial

        for ($i = 0; $i < 256; $i++) {
            for ($part = $i, $bit = 0; $bit < 8; $bit++) {
                if ($part & 1) {
                    $part = (($part >> 1) & ~(0x8 << 60)) ^ $poly64rev;
                } else {
                    $part = ($part >> 1) & ~(0x8 << 60);
                }
            }
            $crc64tab[$i] = $part;
        }

        return $crc64tab;
    }
}
