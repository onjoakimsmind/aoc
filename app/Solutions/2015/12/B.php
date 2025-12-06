<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D12;

use AoC\Solutions\BaseSolution;
use AoC\Testing\TestRunner;

class B extends BaseSolution
{
    public function solve(): int
    {
        $input = $this->getInput();
        $sum = 0;
        $json = json_decode($input, true);

        return $this->sumJson($json);
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part B');
    }

    private function sumJson($data): int
    {
        // If it's a number, just return it
        if (is_int($data)) {
            return $data;
        }

        // If it's an array, it can be either an object (assoc) or a list
        if (is_array($data)) {
            $isAssoc = array_keys($data) !== range(0, count($data) - 1);

            // Object case: skip entirely if any value is "red"
            if ($isAssoc && in_array('red', $data, true)) {
                return 0;
            }

            // Otherwise, sum all children
            $sum = 0;
            foreach ($data as $value) {
                $sum += $this->sumJson($value);
            }
            return $sum;
        }

        // Strings, null, etc. contribute 0
        return 0;
    }
}
