<?php

namespace AoC\Solutions\Y2025\D02;

trait Helper
{
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

    private function isRepeatedPatternAtLeastTwice(int $n): bool
    {
        $s = (string) $n;
        return (bool) preg_match('/^(\d+)\1+$/', $s);
    }
}
