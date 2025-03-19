<?php

/*
 * This file is part of the SimHashPhp package.
 *
 * (c) Titouan Galopin <http://titouangalopin.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VistarSvo\SimHash\Comparator;

use VistarSvo\SimHash\Fingerprint;

interface Comparator
{
    public function compare(Fingerprint $fp1, Fingerprint $fp2): float;
}
