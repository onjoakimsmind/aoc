<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D05;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    public function solve(): int
    {
        [$ranges, $ids] = explode("\n\n", $this->getInput());
        $ranges = explode("\n", trim($ranges));
        $ids = explode("\n", trim($ids));
        $count = 0;
        foreach ($ids as $id) {
            $id = (int)trim($id);
            foreach ($ranges as $index => $range) {
                [$start, $end] = explode("-", $range);
                if ($id >= (int)$start && $id <= (int)$end) {
                    $count++;
                    break;
                }
            }
        }
        return $count;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(3, $this->solve(), 'Part A');
    }
}
