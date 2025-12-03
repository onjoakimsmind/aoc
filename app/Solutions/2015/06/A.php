<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D06;

use AoC\Testing\TestRunner;

class A
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        // TODO: Implement part A solution
        return 0;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part A');
    }
}
