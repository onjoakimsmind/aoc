<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D11;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    use Password;

    public function solve(): string
    {
        $first = (new A($this->inputData))->solve();
        $password = $first;
        do {
            $password = $this->incrementPassword($password);
        } while (!$this->isValidPassword($password));
        return $password;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part B');
    }
}
