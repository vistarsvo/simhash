<?php

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

final readonly class WeightedHammingComparator implements Comparator
{
    use FingerprintSizeValidatorTrait;

    /**
     * @param array<int, float> $weights Weight for each bit position (default: empty for equal weights)
     * @param float $defaultWeight Default weight for positions not specified in $weights
     */
    public function __construct(
        private array $weights = [],
        private float $defaultWeight = 1.0
    ) {
    }

    public function compare(Fingerprint $fp1, Fingerprint $fp2): float
    {
        $this->validateSizes($fp1, $fp2);

        $binary1 = $fp1->getBinary();
        $binary2 = $fp2->getBinary();
        $weightedDistance = 0;
        $totalWeight = 0;
        $size = $fp1->getSize();

        for ($i = 0; $i < $size; $i++) {
            $weight = $this->weights[$i] ?? $this->defaultWeight;
            $totalWeight += $weight;

            if ($binary1[$i] !== $binary2[$i]) {
                $weightedDistance += $weight;
            }
        }

        return $totalWeight > 0 ? 1 - ($weightedDistance / $totalWeight) : 1.0;
    }
}
