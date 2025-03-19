<?php

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

final readonly class JaccardComparator implements Comparator
{
    use FingerprintSizeValidatorTrait;

    public function compare(Fingerprint $fp1, Fingerprint $fp2): float
    {
        $this->validateSizes($fp1, $fp2);

        $binary1 = $fp1->getBinary();
        $binary2 = $fp2->getBinary();

        $intersection = 0;
        $union = 0;

        for ($i = 0; $i < strlen($binary1); $i++) {
            if ($binary1[$i] === '1' && $binary2[$i] === '1') {
                $intersection++;
            }
            if ($binary1[$i] === '1' || $binary2[$i] === '1') {
                $union++;
            }
        }

        return $union > 0 ? $intersection / $union : 1.0;
    }
}
