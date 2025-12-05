<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D05;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(?string $input = null): int
    {
        $input = $input ?? $this->inputData;
        $lines = explode("\n", $input);
        $count = 0;
        foreach ($lines as $line) {
            $hasPairTwice = preg_match('/([a-z]{2}).*\1/', $line);

            $hasRepeatWithGap = preg_match('/([a-z]).\1/', $line);

            if ($hasPairTwice && $hasRepeatWithGap) {
                $count++;
            }

        }
        return $count;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(1, $this->solve("qjhvhtzxzqqjkmpb"), 'Part B (example 1)');
        $t->assertEquals(1, $this->solve("xxyxx"), 'Part B (example 2)');
        $t->assertEquals(0, $this->solve("uurcxstgmygtbstg"), 'Part B (example 3)');
        $t->assertEquals(0, $this->solve("ieodomkazucvgmuy"), 'Part B (example 4)');
    }
}
