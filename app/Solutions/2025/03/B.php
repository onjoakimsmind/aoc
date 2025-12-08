<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D03;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

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
            $sum += $this->maxJoltage($line, 12);
        }
        return $sum;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(3121910778619, $this->solve(), 'Part B');
    }

    private function maxJoltage(string $bank, int $k = 12): int
    {
        $n = strlen($bank);
        if ($k >= $n) {
            return (int)$bank;
        }

        $toRemove = $n - $k;
        $stack = [];

        for ($i = 0; $i < $n; $i++) {
            $d = $bank[$i];

            while ($toRemove > 0 && !empty($stack) && end($stack) < $d) {
                array_pop($stack);
                $toRemove--;
            }

            $stack[] = $d;
        }

        if ($toRemove > 0) {
            $stack = array_slice($stack, 0, count($stack) - $toRemove);
        }

        if (count($stack) > $k) {
            $stack = array_slice($stack, 0, $k);
        }

        return (int)implode('', $stack);
    }
}
