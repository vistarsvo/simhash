<?php

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

final readonly class CosineComparator implements Comparator
{
    use FingerprintSizeValidatorTrait;

    public function compare(Fingerprint $fp1, Fingerprint $fp2): float
    {
        $this->validateSizes($fp1, $fp2);

        $binary1 = $fp1->getBinary();
        $binary2 = $fp2->getBinary();

        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        for ($i = 0; $i < strlen($binary1); $i++) {
            $bit1 = (int)$binary1[$i];
            $bit2 = (int)$binary2[$i];

            $dotProduct += $bit1 * $bit2;
            $magnitude1 += $bit1 * $bit1;
            $magnitude2 += $bit2 * $bit2;
        }

        $magnitude = sqrt($magnitude1) * sqrt($magnitude2);

        return $magnitude > 0 ? $dotProduct / $magnitude : 1.0;
    }
}
