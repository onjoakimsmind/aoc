<?php

namespace AoC\Solutions\Y2015\D10;

trait LookNSay
{
    public static function lookNSay(string $input): string
    {
        $out = "";
        $count = 1;
        $prev = $input[0];
        for ($i = 1; $i < strlen($input); $i++) {
            $ch = $input[$i];
            if ($ch === $prev) {
                $count++;
            } else {
                $out .= $count . $prev;
                $prev = $ch;
                $count = 1;
            }
        }

        $out .= $count . $prev;

        return $out;
    }
}
