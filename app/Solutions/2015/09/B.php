<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D09;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        $lines = explode("\n", $this->inputData);
        $citiesSet = [];
        $dist = [];
        foreach ($lines as $line) {
            if (!preg_match('/(\w+) to (\w+) = (\d+)/', $line, $m)) {
                continue;
            }
            [, $from, $to, $d] = $m;
            $d = (int)$d;
            $dist[$from][$to] = $d;
            $dist[$to][$from] = $d;

            $citiesSet[$from] = true;
            $citiesSet[$to] = true;
        }

        $cities = array_keys($citiesSet);
        $best = PHP_INT_MIN;
        $permute = function (array $path, array $remaining) use (&$permute, &$best, $dist) {
            if (empty($remaining)) {
                $len = 0;
                $count = count($path);
                for ($i = 1; $i < $count; $i++) {
                    $a = $path[$i - 1];
                    $b = $path[$i];
                    $len += $dist[$a][$b];
                }

                if ($len > $best) {
                    $best = $len;
                }
                return;
            }

            foreach ($remaining as $idx => $city) {
                $newPath = $path;
                $newPath[] = $city;

                $newRem = $remaining;
                unset($newRem[$idx]);
                $newRem = array_values($newRem);

                $permute($newPath, $newRem);
            }
        };

        $permute([], $cities);

        return (int)$best;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part B');
    }
}
