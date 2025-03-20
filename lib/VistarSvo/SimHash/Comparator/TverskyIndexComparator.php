<?php

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

final readonly class TverskyIndexComparator implements Comparator
{
    use FingerprintSizeValidatorTrait;

    /**
     * @param float $alpha Weight for differences in first fingerprint
     * @param float $beta Weight for differences in second fingerprint
     */
    public function __construct(
        private float $alpha = 0.5,
        private float $beta = 0.5
    ) {
    }

    public function compare(Fingerprint $fp1, Fingerprint $fp2): float
    {
        $this->validateSizes($fp1, $fp2);

        $binary1 = $fp1->getBinary();
        $binary2 = $fp2->getBinary();

        $common = 0;
        $diffFp1 = 0;
        $diffFp2 = 0;

        for ($i = 0; $i < strlen($binary1); $i++) {
            $bit1 = $binary1[$i] === '1';
            $bit2 = $binary2[$i] === '1';

            if ($bit1 && $bit2) {
                $common++;
            } elseif ($bit1) {
                $diffFp1++;
            } elseif ($bit2) {
                $diffFp2++;
            }
        }

        $denominator = $common + ($this->alpha * $diffFp1) + ($this->beta * $diffFp2);

        return $denominator > 0 ? $common / $denominator : 1.0;
    }
}
