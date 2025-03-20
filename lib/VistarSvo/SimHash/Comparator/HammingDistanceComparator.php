<?php

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

final readonly class HammingDistanceComparator implements Comparator
{
    use FingerprintSizeValidatorTrait;

    /**
     * @param float $normalizationFactor Optional factor to control how the distance affects similarity (default: 1.0)
     */
    public function __construct(
        private float $normalizationFactor = 1.0
    ) {
    }

    public function compare(Fingerprint $fp1, Fingerprint $fp2): float
    {
        $this->validateSizes($fp1, $fp2);

        $binary1 = $fp1->getBinary();
        $binary2 = $fp2->getBinary();
        $distance = 0;
        $size = $fp1->getSize();

        for ($i = 0; $i < $size; $i++) {
            if ($binary1[$i] !== $binary2[$i]) {
                $distance++;
            }
        }

        // Convert distance to similarity score (0 to 1)
        // With normalization factor to control the sensitivity
        return max(0, 1 - ($distance / $size) * $this->normalizationFactor);
    }
}
