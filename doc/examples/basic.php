<?php

require 'vendor/autoload.php';

$text1 = '
Partner with Gopuff to deliver everyday essentialswith flexible work to suit you. Ready to deliver every day magic?Become a Gopuff delivery partner today!
Complete your application in under 10 minutes and bedelivering within 48hrs!
Application requiresdocument upload (5 mins), online training (5 mins) and serviceagreement signing. Make sure you have your ID, proof of right towork, and vehicle documents (eg. driving license and insurance) tohand and we’ll get you on the road very quickly.
';

$text2 = '
  everyday essentialswith flexible work to suit you. Ready to deliver every day magic?Become a Gopuff delivery partner today!
Complete your application in under 10 minutes and bedelivering within 48hrs!
Application  upload , online training (5 mins) and signing. Make sure you have your ID, proof of right towork, and vehicle documents (eg. driving license and insurance) tohand and we’ll get you on the road very quickly.
';

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
