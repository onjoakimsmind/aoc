<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D07;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    public function solve(): int
    {

        $lines = preg_split('/\R+/', trim($this->getInput()));
        $rows  = count($lines);
        if ($rows === 0) {
            return 0;
        }
        $cols  = strlen($lines[0]);
        $startRow = null;
        $startCol = null;
        foreach ($lines as $r => $line) {
            $pos = strpos($line, 'S');
            if ($pos !== false) {
                $startRow = $r;
                $startCol = $pos;
                break;
            }
        }

        if ($startRow === null) {
            return 0;
        }

        $count       = 0;
        $currentCols = [$startCol];
        for ($r = $startRow + 1; $r < $rows; $r++) {
            $line     = $lines[$r];
            $nextCols = [];

            $currentCols = array_values(array_unique($currentCols));

            foreach ($currentCols as $c) {
                if ($c < 0 || $c >= $cols) {
                    continue;
                }

                $cell = $line[$c];

                if ($cell === '^') {
                    $count++;

                    if ($c - 1 >= 0) {
                        $nextCols[] = $c - 1;
                    }
                    if ($c + 1 < $cols) {
                        $nextCols[] = $c + 1;
                    }
                } else {
                    $nextCols[] = $c;
                }
            }

            $currentCols = $nextCols;
        }

        return $count;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(21, $this->solve(), 'Part A');
    }
}
