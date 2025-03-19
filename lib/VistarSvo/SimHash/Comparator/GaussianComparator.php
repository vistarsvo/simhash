<?php

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

final readonly class GaussianComparator implements Comparator
{
    use FingerprintSizeValidatorTrait;

    public function __construct(private int $deviation = 4)
    {
    }

    public function compare(Fingerprint $fp1, Fingerprint $fp2): float
    {
        $this->validateSizes($fp1, $fp2);

        // Get binary strings and count differences directly
        $binary1 = $fp1->getBinary();
        $binary2 = $fp2->getBinary();
        $countDifferences = 0;

        for ($i = 0; $i < strlen($binary1); $i++) {
            if ($binary1[$i] !== $binary2[$i]) {
                $countDifferences++;
            }
        }

        return $this->computeSimilarityIndex($countDifferences);
    }

    protected function computeSimilarityIndex(int $countDifferences): float
    {
        return $this->gaussianDensity($countDifferences) / $this->gaussianDensity(0);
    }

    protected function gaussianDensity(int $x): float
    {
        $y = -0.5 * pow(num: $x / $this->deviation, exponent: 2);
        $y = exp($y);

        return (1 / sqrt(2 * pi())) * $y;
    }
}
