<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D03;

use AoC\Testing\TestRunner;

class A
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        $input = explode("\n", $this->inputData);
        $sum = 0;
        foreach ($input as $line) {
            $sum += $this->bestJoltagePair($line);
        }
        return $sum;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(357, $this->solve(), 'Part A');
    }

    private function bestJoltagePair(string $bank): ?int
    {
        $len = strlen($bank);
        if ($len < 2) {
            return null;
        }

        $bestTensDigit = (int)$bank[0];

        $bestValue = -1;
        $bestPair = null;

        for ($i = 1; $i < $len; $i++) {
            $onesDigit = (int)$bank[$i];

            $candidate = $bestTensDigit * 10 + $onesDigit;

            if ($candidate > $bestValue) {
                $bestValue = $candidate;
                $bestPair = $bestValue;
            }

            if ($onesDigit > $bestTensDigit) {
                $bestTensDigit = $onesDigit;
            }
        }

        return $bestPair;
    }
}
