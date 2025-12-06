<?php

namespace AoC\Solutions\Y2015\D11;

trait Password
{
    private function incrementPassword(string $s): string
    {
        $chars = str_split($s);
        for ($i = count($chars) - 1; $i >= 0; $i--) {
            if ($chars[$i] === 'z') {
                $chars[$i] = 'a';
            } else {
                $chars[$i] = chr(ord($chars[$i]) + 1);

                if (in_array($chars[$i], ['i', 'o', 'l'], true)) {
                    $chars[$i] = chr(ord($chars[$i]) + 1);
                    for ($j = $i + 1; $j < count($chars); $j++) {
                        $chars[$j] = 'a';
                    }
                }

                break;
            }
        }

        return implode('', $chars);
    }

    private function isValidPassword(string $s): bool
    {
        if (strpbrk($s, 'iol') !== false) {
            return false;
        }

        if (!$this->hasStraight($s)) {
            return false;
        }

        if (!$this->hasTwoDifferentPairs($s)) {
            return false;
        }

        return true;
    }

    private function hasStraight(string $s): bool
    {
        $len = strlen($s);
        for ($i = 0; $i <= $len - 3; $i++) {
            $a = ord($s[$i]);
            $b = ord($s[$i + 1]);
            $c = ord($s[$i + 2]);
            if ($b === $a + 1 && $c === $b + 1) {
                return true;
            }
        }
        return false;
    }

    private function hasTwoDifferentPairs(string $s): bool
    {
        $len = strlen($s);
        $pairs = [];

        $i = 0;
        while ($i < $len - 1) {
            if ($s[$i] === $s[$i + 1]) {
                $pairs[$s[$i]] = true;
                $i += 2;
            } else {
                $i++;
            }
        }

        return count($pairs) >= 2;
    }
}
