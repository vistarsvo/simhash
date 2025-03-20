SimHash
==========

> This is the another version of SimHashPHP. The fork. The original version is [here](https://github.com/tgalopin/simhashphp)

What is SimHash ?
--------------------

SimHash is a PHP library that port the SimHash algorithm in PHP.
This algorithm, created by Moses Charikar, provides an efficient way to compute a similarity index between two texts.
It is used by Google internally to detect duplicate content.

How to use it ?
---------------

Install it with [Composer](https://getcomposer.org):

``` sh
composer require vistarsvo/simhash
```

Once installed, include `vendor/autoload.php` to load the library.

``` php
<?php

require 'vendor/autoload.php';

$text1 = <<<EOT
George Headley (1909–1983) was a West Indian cricketer who played 22 Test matches, mostly before the Second World War.
Considered one of the best batsmen to play for West Indies and one of the greatest cricketers of all time, he also
represented Jamaica and played professionally in England. Headley was born in Panama but raised in Jamaica where he
quickly established a cricketing reputation as a batsman. West Indies had a weak cricket team through most of Headley's
career; as their one world-class player, he carried a heavy responsibility, and they depended on his batting. He batted
at number three, scoring 2,190 runs in Tests at an average of 60.83, and 9,921 runs in all first-class matches at an
average of 69.86. He was chosen as one of the Wisden Cricketers of the Year in 1934.
EOT;

$text2 = <<<EOT
George Headley was a West Indian cricketer who played 22 Test matches, mostly before the Second World War.
Considered one of the best batsmen to play for West Indies and one of the greatest cricketers of all time, he also
represented Jamaica and played professionally in England. Headley was born in Panama but raised in Jamaica where he
quickly established a cricketing reputation as a batsman. West Indies had a weak cricket team through most of Headley's
career; as their one world-class player, he carried a heavy responsibility, and they depended on his batting. He batted
at number three, scoring 2,190 runs in tests at an average of 60.83, and 9,921 runs in all first-class matches at an
average of 69.86. He was chosen as one of the Wisden Cricketers of the Year.
EOT;



$simHash = (new \VistarSvo\SimHash\Factories\DefaultSimHashFactory())->createSimHash(256);

/** @var \VistarSvo\SimHash\Comparator\Comparator[] $comparators */
$comparators = [
    'gaussian30' => new \VistarSvo\SimHash\Comparator\GaussianComparator(30),
    'gaussian10' => new \VistarSvo\SimHash\Comparator\GaussianComparator(10),
    'gaussian4' => new \VistarSvo\SimHash\Comparator\GaussianComparator(4),
    'gaussian1' => new \VistarSvo\SimHash\Comparator\GaussianComparator(1),
    'cosine' => new \VistarSvo\SimHash\Comparator\CosineComparator(),
    'jaccard' => new \VistarSvo\SimHash\Comparator\JaccardComparator(),
    'threshold1' => new \VistarSvo\SimHash\Comparator\ThresholdComparator(1),
    'threshold10' => new \VistarSvo\SimHash\Comparator\ThresholdComparator(10),
    'dice' => new \VistarSvo\SimHash\Comparator\DiceCoefficientComparator(),
    'tversky' => new \VistarSvo\SimHash\Comparator\TverskyIndexComparator(),
    'hamming1.0' => new \VistarSvo\SimHash\Comparator\HammingDistanceComparator(),
    'hamming0.1' => new \VistarSvo\SimHash\Comparator\HammingDistanceComparator(0.1),
    'hamming0.5' => new \VistarSvo\SimHash\Comparator\HammingDistanceComparator(0.5),
    'weightedhamming' => new \VistarSvo\SimHash\Comparator\HammingDistanceComparator(0.5),
];

$fp1 = $simHash->makeHash($text1);
$fp2 = $simHash->makeHash($text2);

foreach ($comparators as $comparatorName => $comparator) {
    echo $comparatorName . ': ' . $comparator->compare($fp1, $fp2) . PHP_EOL;
}
```

License
-------

This library is under the MIT license (see LICENSE.md)


