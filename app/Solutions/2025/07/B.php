<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D07;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    public function solve(): int
    {
        $lines = preg_split('/\R+/', trim($this->getInput()));
        $rows  = count($lines);

        if ($rows === 0) {
            return 0;
        }

        $cols = strlen($lines[0]);

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

        $current  = [$startCol => 1];
        $finished = 0;
        $r        = $startRow;

        while (!empty($current)) {
            if ($r === $rows - 1) {
                foreach ($current as $cnt) {
                    $finished += $cnt;
                }
                break;
            }

            $next = [];

            foreach ($current as $c => $cnt) {
                if ($c < 0 || $c >= $cols) {
                    $finished += $cnt;
                    continue;
                }

                $cell = $lines[$r + 1][$c];

                if ($cell === '^') {
                    $left  = $c - 1;
                    $right = $c + 1;

                    if ($left >= 0) {
                        if (!isset($next[$left])) {
                            $next[$left] = 0;
                        }
                        $next[$left] += $cnt;
                    } else {
                        $finished += $cnt;
                    }

                    if ($right < $cols) {
                        if (!isset($next[$right])) {
                            $next[$right] = 0;
                        }
                        $next[$right] += $cnt;
                    } else {
                        $finished += $cnt;
                    }
                } else {
                    if (!isset($next[$c])) {
                        $next[$c] = 0;
                    }
                    $next[$c] += $cnt;
                }
            }

            $current = $next;
            $r++;
        }

        return $finished;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(40, $this->solve(), 'Part B');
    }
}
