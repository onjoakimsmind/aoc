<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D08;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
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
            $inMemoryLen += strlen('"' . addslashes($line) . '"');
        }
        return $inMemoryLen - $strLen;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(19, $this->solve(), 'Part B');
    }
}
