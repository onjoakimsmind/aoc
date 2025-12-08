<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D02;

use AoC\Solutions\BaseSolution;
use Aoc\Testing\TestRunner;

class B extends BaseSolution
{
    protected string $input;

    public function __construct(string $input)
    {
        $this->inputData = trim($input);
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
