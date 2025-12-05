<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D10;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    use LookNSay;

    protected string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        $input = $this->inputData;

        for ($i = 0; $i < 40; $i++) {
            $input = $this->lookNSay($input);
        }
        return strlen($input);
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part A');
    }
}
