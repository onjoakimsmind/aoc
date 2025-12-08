<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D08;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    protected string $input;

    public function __construct(string $input)
    {
        $this->inputData = trim($input);
    }

    public function solve(): int
    {
        $input = explode("\n", $this->inputData);
        $strLen = 0;
        $inMemoryLen = 0;
        foreach ($input as $line) {
            if (empty($line) || $line === '') {
                continue;
            }
            $strLen += strlen($line);
            $inner = substr($line, 1, -1);
            $inMemory = stripcslashes($inner);
            $inMemoryLen += strlen($inMemory);
        }
        return $strLen - $inMemoryLen;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(12, $this->solve(), 'Part A');
    }
}
