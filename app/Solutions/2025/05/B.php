<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D05;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    public function solve(): int
    {
        [$rangesBlock] = preg_split('/\R\R/', trim($this->getInput()), 2);

        $ranges = [];
        foreach (preg_split('/\R/', trim($rangesBlock)) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            if (!str_contains($line, '-')) {
                throw new \RuntimeException("Invalid range line (missing '-'): '$line'");
            }

            [$start, $end] = array_map('intval', explode('-', $line, 2));
            if ($end < $start) {
                [$start, $end] = [$end, $start];
            }

            $ranges[] = [$start, $end];
        }

        if (empty($ranges)) {
            return 0;
        }

        usort($ranges, fn (array $a, array $b) => $a[0] <=> $b[0]);

        $merged = [];
        [$curStart, $curEnd] = $ranges[0];

        for ($i = 1, $n = count($ranges); $i < $n; $i++) {
            [$s, $e] = $ranges[$i];

            if ($s <= $curEnd + 1) {
                if ($e > $curEnd) {
                    $curEnd = $e;
                }
            } else {
                $merged[] = [$curStart, $curEnd];
                $curStart = $s;
                $curEnd   = $e;
            }
        }
        $merged[] = [$curStart, $curEnd];

        $total = 0;
        foreach ($merged as [$start, $end]) {
            $total += ($end - $start + 1);
        }

        return $total;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(14, $this->solve(), 'Part B');
    }
}
