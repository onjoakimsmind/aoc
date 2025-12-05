<?php

declare(strict_types=1);

namespace Y2015\D02;

use AoC\Solutions\BaseSolution;

use Aoc\Testing\TestRunner;

class B extends BaseSolution
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
            [$w, $h, $l] = array_map('intval', explode('x', $line));
            $extra = $w * $h * $l;
            $dims = [$w, $h, $l];
            sort($dims, SORT_NUMERIC);
            $sum += ($dims[0] * 2) + ($dims[1] * 2) + $extra;
        }
        return $sum;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(48, $this->solve(), 'Part B');
    }
}
