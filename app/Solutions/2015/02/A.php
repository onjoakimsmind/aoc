<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D02;

use AoC\Solutions\BaseSolution;
use Aoc\Testing\TestRunner;

class A extends BaseSolution
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
            $smallest = min($w * $h, $h * $l, $l * $w);
            $sum += (2 * $w * $h) + (2 * $h * $l) + (2 * $l * $w) + $smallest;
        }
        return $sum;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part A');
    }
}
