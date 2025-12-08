<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D07;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;

require_once __DIR__ . '/A.php';

class B extends BaseSolution
{
    protected string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        $a = new A($this->inputData);
        return $a->solve(null, $a->solve());
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part B');
    }
}
