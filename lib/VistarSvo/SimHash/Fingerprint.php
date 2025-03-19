<?php

namespace VistarSvo\SimHash;

final readonly class Fingerprint
{
    private string $binaryString;

    public function __construct(
        private int $size,
        string $binaryData
    ) {
        $this->binaryString = str_pad($binaryData, $size, '0', STR_PAD_LEFT);
    }

    public function __toString(): string
    {
        return $this->getBinary();
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getBinary(): string
    {
        return $this->binaryString;
    }

    public function getHexa(): string
    {
        $hex = '';
        for ($i = 0; $i < strlen($this->binaryString); $i += 4) {
            $chunk = substr($this->binaryString, $i, 4);
            $chunk = str_pad($chunk, 4, '0', STR_PAD_RIGHT);
            $hex .= dechex(bindec($chunk));
        }
        return $hex;
    }

    public function getDecimal(): string
    {
        if (function_exists('gmp_init')) {
            return gmp_strval(gmp_init($this->binaryString, 2));
        }

        // For small enough values only
        if (strlen($this->binaryString) <= 31) {
            return (string)bindec($this->binaryString);
        }

        // Fallback for large values without GMP
        throw new \RuntimeException('Binary too large for decimal conversion. Install GMP extension.');
    }
}
