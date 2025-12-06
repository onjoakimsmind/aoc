<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D06;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    public function solve(): int
    {
        $input = rtrim($this->getInput(), "\r\n");
        $lines = preg_split('/\R+/', $input);
        $height = count($lines);
        $width = max(array_map('strlen', $lines));
        foreach ($lines as &$line) {
            $line = str_pad($line, $width, ' ');
        }
        unset($line);

        $grid = array_map('str_split', $lines);

        $separator = array_fill(0, $width, false);

        for ($c = 0; $c < $width; $c++) {
            $allSpace = true;
            for ($r = 0; $r < $height; $r++) {
                if ($grid[$r][$c] !== ' ') {
                    $allSpace = false;
                    break;
                }
            }
            if ($allSpace) {
                $separator[$c] = true;
            }
        }

        $blocks = [];
        $c = 0;

        while ($c < $width) {
            if ($separator[$c]) {
                $c++;
                continue;
            }

            $start = $c;
            while ($c < $width && !$separator[$c]) {
                $c++;
            }
            $end = $c - 1;

            $blocks[] = [$start, $end];
        }

        $total = 0;

        foreach ($blocks as [$start, $end]) {
            $op = null;
            for ($c = $start; $c <= $end; $c++) {
                $ch = $grid[$height - 1][$c];
                if ($ch !== ' ') {
                    $op = $ch;
                    break;
                }
            }

            if ($op === null) {
                continue;
            }

            $operands = [];

            for ($c = $end; $c >= $start; $c--) {
                $digits = '';

                for ($r = 0; $r < $height - 1; $r++) {
                    $ch = $grid[$r][$c];

                    if ($ch !== ' ') {
                        $digits .= $ch;
                    }
                }

                if ($digits !== '') {
                    $operands[] = (int) $digits;
                }
            }

            if (empty($operands)) {
                continue;
            }

            $value = array_shift($operands);

            foreach ($operands as $operand) {
                switch ($op) {
                    case '+':
                        $value += $operand;
                        break;
                    case '*':
                        $value *= $operand;
                        break;
                    default:
                        throw new \RuntimeException("Unknown operator: $op");
                }
            }

            $total += $value;
        }

        return $total;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(3263827, $this->solve(), 'Part B');
    }
}
