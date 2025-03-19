<?php

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

final readonly class ThresholdComparator implements Comparator
{
    use FingerprintSizeValidatorTrait;

    public function __construct(
        private int $threshold,
        private float $highSimilarity = 0.9,
        private float $lowSimilarity = 0.1
    ) {
    }

    public function compare(Fingerprint $fp1, Fingerprint $fp2): float
    {
        $this->validateSizes($fp1, $fp2);

        $binary1 = $fp1->getBinary();
        $binary2 = $fp2->getBinary();
        $differences = 0;

        for ($i = 0; $i < strlen($binary1); $i++) {
            if ($binary1[$i] !== $binary2[$i]) {
                $differences++;
            }
        }

        if ($differences === 0) {
            return 1.0;
        }

        if ($differences <= $this->threshold) {
            // Linear decrease from 1.0 to highSimilarity
            return 1.0 - (1.0 - $this->highSimilarity) * ($differences / $this->threshold);
        }

        // Linear decrease from highSimilarity to lowSimilarity
        $maxDiff = $fp1->getSize();
        $remainingDiff = $differences - $this->threshold;
        $remainingRange = $maxDiff - $this->threshold;

        return $this->highSimilarity - ($this->highSimilarity - $this->lowSimilarity) *
            ($remainingDiff / max(1, $remainingRange));
    }
}
