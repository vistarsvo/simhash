<?php

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

final readonly class DiceCoefficientComparator implements Comparator
{
    use FingerprintSizeValidatorTrait;

    public function compare(Fingerprint $fp1, Fingerprint $fp2): float
    {
        $this->validateSizes($fp1, $fp2);

        $binary1 = $fp1->getBinary();
        $binary2 = $fp2->getBinary();

        $intersection = 0;
        $total1 = 0;
        $total2 = 0;

        for ($i = 0; $i < strlen($binary1); $i++) {
            $bit1 = $binary1[$i] === '1' ? 1 : 0;
            $bit2 = $binary2[$i] === '1' ? 1 : 0;

            if ($bit1 && $bit2) {
                $intersection++;
            }

            $total1 += $bit1;
            $total2 += $bit2;
        }

        return ($total1 + $total2 > 0) ? (2 * $intersection) / ($total1 + $total2) : 1.0;
    }
}
