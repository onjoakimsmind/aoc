<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D06;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    protected string $input;

    public function __construct(string $input)
    {
        $this->inputData = trim($input);
    }

    public function solve(?string $input = null): int
    {
        $input = $input ?? $this->inputData;
        $commands = explode("\n", trim($input));

        $grid = array_fill(0, 1000000, 0);
        foreach ($commands as $command) {
            if (!preg_match('/(turn on|turn off|toggle) (\d+),(\d+) through (\d+),(\d+)/', $command, $m)) {
                continue;
            }

            [$full, $action, $x1, $y1, $x2, $y2] = $m;

            $x1 = (int)$x1;
            $y1 = (int)$y1;
            $x2 = (int)$x2;
            $y2 = (int)$y2;

            for ($x = $x1; $x <= $x2; $x++) {
                $rowStart = $x * 1000;

                for ($y = $y1; $y <= $y2; $y++) {
                    $i = $rowStart + $y;

                    if ($action === "turn on") {
                        $grid[$i] += 1;
                    } elseif ($action === "turn off") {
                        if ($grid[$i] > 0) {
                            $grid[$i] -= 1;
                        }
                    } else {
                        $grid[$i] += 2;
                    }
                }
            }
        }

        return array_sum($grid);
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(1, $this->solve("turn on 0,0 through 0,0"), 'Part B (example 1)');
        $t->assertEquals(2000000, $this->solve("toggle 0,0 through 999,999"), 'Part B (example 2)');
    }
}
