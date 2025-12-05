<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D04;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(?string $input = null): int
    {
        $input = $input ?? $this->inputData;
        $i = 1;
        $target = '00000';
        while (true) {
            if (strcmp(substr(md5($input . $i), 0, 5), $target) === 0) {
                return $i;
            }
            $i++;
        }
        return 0;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(609043, $this->solve("abcdef"), 'Part A (example 1)');
        $t->assertEquals(1048970, $this->solve("pqrstuv"), 'Part A (example 2)');
    }
}
