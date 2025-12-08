<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D02;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    use Helper;

    protected string $input;

    public function __construct(string $input)
    {
        $this->inputData = trim($input);
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
                if ($this->isRepeatedTwice($j)) {
                    $invalid[] = $j;
                    $sum += $j;
                }
            }
        }

        return $sum;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(1227775554, $this->solve(), 'Part A');
    }
}
