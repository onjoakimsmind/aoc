<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D03;

use AoC\Testing\TestRunner;

class A
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(?string $input = null): int
    {
        $x = 0;
        $y = 0;

        $input = $input ?? $this->inputData;

        $visited = [];
        $visited["$x,$y"] = true;
        foreach (str_split($input) as $char) {
            if ($char === '^') {
                $y++;
            } elseif ($char === 'v') {
                $y--;
            } elseif ($char === '>') {
                $x++;
            } elseif ($char === '<') {
                $x--;
            }

            $visited["$x,$y"] = true;
        }

        return count($visited);
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(2, $this->solve(">"), 'Part A (example 1)');
        $t->assertEquals(4, $this->solve("^>v<"), 'Part A (example 2)');
        $t->assertEquals(2, $this->solve("^v^v^v^v^v"), 'Part A (example 3)');
    }
}
