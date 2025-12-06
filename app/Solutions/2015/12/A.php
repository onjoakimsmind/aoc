<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D12;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    public function solve(): int
    {
        $input = $this->getInput();
        $sum = 0;
        preg_match_all('/-?\d+/', $input, $matches);

        array_map(
            function ($value) use (&$sum) {
                $sum += (int)$value;
            },
            $matches[0]
        );
        return $sum;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part A');
    }
}
