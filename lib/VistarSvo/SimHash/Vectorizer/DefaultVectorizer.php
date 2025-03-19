<?php

namespace VistarSvo\SimHash\Vectorizer;

final class DefaultVectorizer implements Vectorizer
{
    /**
     * @param array<string> $tokens
     * @param int $size
     * @return array
     */
    public function vectorize(array $tokens, int $size): array
    {
        $weightTokens = $this->createWeightTokens($tokens);
        $vector = array_fill(0, $size, 0);

        foreach ($weightTokens as $token => $weight) {
            for ($i = 0; $i < $size; $i++) {
                if ($token[$i] === '1') {
                    $vector[$i] += (int) $weight;
                } else {
                    $vector[$i] -= (int) $weight;
                }
            }
        }

        return $vector;
    }

    protected function createWeightTokens(array $tokens): array
    {
        $weightTokens = [];

        foreach ($tokens as $token) {
            if (! array_key_exists($token, $weightTokens)) {
                $weightTokens[$token] = 1;
            } else {
                $weightTokens[$token]++;
            }
        }

        return $weightTokens;
    }
}
