<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D01;

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
        $floor = 0;
        for ($i = 0; $i < strlen($this->inputData); $i++) {
            if ($this->inputData[$i] === '(') {
                $floor++;
            } elseif ($this->inputData[$i] === ')') {
                $floor--;
            }
        }

        return $floor;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part A');
    }
}
