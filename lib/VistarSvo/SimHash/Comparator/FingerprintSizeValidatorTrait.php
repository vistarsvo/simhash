<?php

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

trait FingerprintSizeValidatorTrait
{
    protected function validateSizes(Fingerprint $fp1, Fingerprint $fp2): void
    {
        if ($fp1->getSize() !== $fp2->getSize()) {
            throw new \LogicException(sprintf(
                'The fingerprints passed to the Gaussian comparator have different sizes (%s bits and %s bits).',
                $fp1->getSize(), $fp2->getSize()
            ));
        }
    }
}
