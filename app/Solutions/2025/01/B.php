<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D01;

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
        $pos = 50;
        $instructions = preg_split('/\R/', $this->inputData);
        $count = 0;

        foreach ($instructions as $instruction) {
            preg_match('/^(\D)(\d+)$/', $instruction, $matches);
            [$direction, $value] = array_slice($matches, 1);

            for ($i = 0; $i < $value; $i++) {
                if ($direction === 'L') {
                    $pos = ($pos - 1 + 100) % 100;
                } else {
                    $pos = ($pos + 1) % 100;
                }

                if ($pos === 0) {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(6, $this->solve(), 'Part B');
    }
}
