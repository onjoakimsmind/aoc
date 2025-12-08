<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D04;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    protected string $input;

    public function __construct(string $input)
    {
        $this->inputData = trim($input);
    }

    public function solve(): int
    {
        $grid = $this->inputData === '' ? [] : explode("\n", $this->inputData);
        $h = count($grid);
        if ($h === 0) {
            return 0;
        }
        $w = strlen($grid[0]);
        $count = 0;

        $dirs = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1],           [0, 1],
            [1, -1],  [1, 0],  [1, 1],
        ];


        for ($r = 0; $r < $h; $r++) {
            $row = $grid[$r];
            $outRow = '';

            for ($c = 0; $c < $w; $c++) {
                $ch = $row[$c];

                if ($ch !== '@') {
                    $outRow .= $ch;
                    continue;
                }

                $adjAt = 0;
                foreach ($dirs as [$dr, $dc]) {
                    $rr = $r + $dr;
                    $cc = $c + $dc;

                    if ($rr < 0 || $rr >= $h || $cc < 0 || $cc >= $w) {
                        continue;
                    }

                    if ($grid[$rr][$cc] === '@') {
                        $adjAt++;
                    }
                }

                if ($adjAt < 4) {
                    $count++;
                }
            }
        }

        return $count;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(13, $this->solve(), 'Part A');
    }
}
