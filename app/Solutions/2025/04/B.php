<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D04;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    use Helper;

    protected string $input;

    public function __construct(string $input)
    {
        $this->inputData = trim($input);
    }

    public function solve(): int
    {
        $grid = $this->inputData === '' ? [] : explode("\n", $this->inputData);
        $final = $this->stabilizeGrid($grid);
        $initialAt = 0;
        $finalAt = 0;

        foreach ($grid as $row) {
            $initialAt += substr_count($row, '@');
        }

        foreach ($final as $row) {
            $finalAt += substr_count($row, '@');
        }

        return $initialAt - $finalAt;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(43, $this->solve(), 'Part B');
    }
}
