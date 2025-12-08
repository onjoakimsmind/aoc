<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D05;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    public function solve(?string $input = null): int
    {
        $input = $input ?? $this->input;
        $lines = explode("\n", $input);
        $forbidden = ['ab', 'cd', 'pq', 'xy'];
        $count = 0;
        foreach ($lines as $line) {
            if (array_filter($forbidden, fn ($item) => str_contains($line, $item))) {
                continue;
            }

            if (!preg_match('/[aeiou].*[aeiou].*[aeiou]/', $line)) {
                continue;
            }

            if (!preg_match('/([a-z])\1/', $line)) {
                continue;
            }
            $count++;
        }
        return $count;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(2, $this->solve(), 'Part A');
    }
}
