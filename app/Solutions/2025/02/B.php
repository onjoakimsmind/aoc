<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D02;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    use Helper;

    protected string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        $input = explode(",", $this->inputData);
        $invalid = [];
        $sum = 0;
        foreach ($input as $i => $value) {
            $value = trim($value);
            if ($value === '') {
                continue;
            }

            [$start, $end] = explode("-", $value);
            for ($j = (int)$start; $j <= (int)$end; $j++) {
                if ($this->isRepeatedPatternAtLeastTwice($j)) {
                    $invalid[] = $j;
                    $sum += $j;
                }
            }
        }

        return $sum;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(4174379265, $this->solve(), 'Part B');
    }
}
