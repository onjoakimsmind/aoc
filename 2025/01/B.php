<?php

declare(strict_types=1);

namespace Y2025\D01;

use Aoc\Testing\TestRunner;

class B
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
        $t->assertEquals(6, (new B($testInput))->solve(), 'Part B');
    }
}

function test(TestRunner $t, string $testInput): void
{
    (new B($testInput))->test($t, $testInput);
}
