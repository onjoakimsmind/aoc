<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D03;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    protected string $input;

    public function __construct(string $input)
    {
        $this->inputData = trim($input);
    }

    public function solve(?string $input = null): int
    {
        $input = $input ?? $this->inputData;

        $x = 0;
        $y = 0;
        $robotX = 0;
        $robotY = 0;
        $visited = [];
        $visited["$x,$y"] = true;
        $isSantaTurn = true;
        foreach (str_split($input) as $char) {
            if ($char === '^') {
                $isSantaTurn ? $y++ : $robotY++;
            } elseif ($char === 'v') {
                $isSantaTurn ? $y-- : $robotY--;
            } elseif ($char === '>') {
                $isSantaTurn ? $x++ : $robotX++;
            } elseif ($char === '<') {
                $isSantaTurn ? $x-- : $robotX--;
            }
            $isSantaTurn ? $visited["$x,$y"] = true : $visited["$robotX,$robotY"] = true;
            $isSantaTurn = !$isSantaTurn;
        }
        return count($visited);
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(3, $this->solve("^v"), 'Part B (example 1)');
        $t->assertEquals(3, $this->solve("^>v<"), 'Part B (example 2)');
        $t->assertEquals(11, $this->solve("^v^v^v^v^v"), 'Part B (example 3)');
    }
}
