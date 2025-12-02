<?php

declare(strict_types=1);

namespace Y2025\D02;

use Aoc\Testing\TestRunner;

class A
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        $input = explode(",", $this->inputData);
        $invalid = [];
        $sum = 0;
        foreach ($input as $i => $value) {
            $value = trim($value);
            if ($value === '') {
                continue;
            }

            [$start, $end] = explode("-", $value);
            for ($j = (int)$start; $j <= (int)$end; $j++) {
                if ($this->isRepeatedTwice($j)) {
                    $invalid[] = $j;
                    $sum += $j;
                }
            }
        }

        return $sum;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(1227775554, $this->solve(), 'Part A');
    }

    private function isRepeatedTwice(int $number): bool
    {
        $s = (string)$number;
        $len = strlen($s);

        if ($len % 2 !== 0) {
            return false;
        }

        $half = intdiv($len, 2);
        $first = substr($s, 0, $half);
        $second = substr($s, $half);

        return $first === $second;
    }
}
