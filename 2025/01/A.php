<?php

declare(strict_types=1);

namespace Y2025\D01;

use Aoc\Testing\TestRunner;

class A
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        $pos = 50;
        $instructions = preg_split('/\R/', $this->inputData);
        $count = 0;

        foreach ($instructions as $instruction) {
            preg_match('/^(\D)(\d+)$/', $instruction, $matches);
            [$direction, $value] = array_slice($matches, 1);

            if ($direction === 'L') {
                $pos = ($pos - $value + 100) % 100;
            } else {
                $pos = ($pos + $value) % 100;
            }

            if ($pos === 0) {
                $count++;
            }
        }

        return $count;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(3, $this->solve(), 'Part A');
    }
}
