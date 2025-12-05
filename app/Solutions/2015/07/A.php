<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D07;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;

class A extends BaseSolution
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(?string $input = null, $overrideB = null): int
    {
        $input = $input ?? $this->inputData;
        $wires = [];
        $lines = explode("\n", $input);
        foreach ($lines as $line) {
            if (preg_match('/(.+) -> (\w+)/', $line, $m)) {
                $expr = trim($m[1]);
                $out = trim($m[2]);
                $wires[$out] = $expr;
            }
        }

        if ($overrideB !== null) {
            $wires['b'] = (string)$overrideB;
        }

        $cache = [];
        $eval = function ($wire) use (&$eval, &$wires, &$cache) {
            if (ctype_digit($wire)) {
                return (int)$wire;
            }

            if (isset($cache[$wire])) {
                return $cache[$wire];
            }

            $expr = $wires[$wire];

            if (preg_match('/NOT (\w+)/', $expr, $m)) {
                return $cache[$wire] = (~$eval($m[1])) & 0xFFFF;
            }

            if (preg_match('/(\w+) (AND|OR|LSHIFT|RSHIFT) (\w+)/', $expr, $m)) {
                [$all, $a, $op, $b] = $m;
                $a = $eval($a);
                $b = $eval($b);

                switch ($op) {
                    case "AND":
                        $res = $a & $b;
                        break;
                    case "OR":
                        $res = $a | $b;
                        break;
                    case "LSHIFT":
                        $res = ($a << $b) & 0xFFFF;
                        break;
                    case "RSHIFT":
                        $res = $a >> $b;
                        break;
                }

                return $cache[$wire] = $res;
            }

            return $cache[$wire] = $eval($expr);
        };

        $output = [];
        foreach ($wires as $wire => $_) {
            $output[$wire] = $eval($wire);
        }
        return $output['a'];
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part A');
    }
}
