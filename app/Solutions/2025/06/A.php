<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D06;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    public function solve(): int
    {
        $lines = preg_split('/\R+/', $this->getInput());
        $ops = preg_split('/\s+/', trim(array_pop($lines)), -1, PREG_SPLIT_NO_EMPTY);
        $sum = 0;
        $rows = array_map(
            fn (string $line) => array_map(
                'intval',
                preg_split('/\s+/', trim($line), -1, PREG_SPLIT_NO_EMPTY)
            ),
            $lines
        );
        foreach ($ops as $colIndex => $op) {
            $expr = implode($op, array_column($rows, $colIndex));
            $sum += eval('return ' . $expr . ';');
        }
        return $sum;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(4277556, $this->solve(), 'Part A');
    }
}
