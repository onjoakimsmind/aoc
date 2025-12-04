<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2025\D04;

use AoC\Testing\TestRunner;

class B
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        $grid = $this->inputData === '' ? [] : explode("\n", $this->inputData);
        $final = $this->stabilizeGrid($grid);
        $initialAt = 0;
        $finalAt = 0;

        foreach ($grid as $row) {
            $initialAt += substr_count($row, '@');
        }

        foreach ($final as $row) {
            $finalAt += substr_count($row, '@');
        }

        return $initialAt - $finalAt;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(43, $this->solve(), 'Part B');
    }

    private function stabilizeGrid(array $grid): array
    {
        $h = count($grid);
        if ($h === 0) {
            return [];
        }

        $gridChars = [];
        foreach ($grid as $row) {
            $gridChars[] = str_split($row);
        }

        $w = count($gridChars[0]);

        $dirs = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1],           [0, 1],
            [1, -1],  [1, 0],  [1, 1],
        ];

        while (true) {
            $toRemove = [];

            for ($r = 0; $r < $h; $r++) {
                for ($c = 0; $c < $w; $c++) {
                    if ($gridChars[$r][$c] !== '@') {
                        continue;
                    }

                    $adjAt = 0;
                    foreach ($dirs as [$dr, $dc]) {
                        $rr = $r + $dr;
                        $cc = $c + $dc;

                        if ($rr < 0 || $rr >= $h || $cc < 0 || $cc >= $w) {
                            continue;
                        }
                        if ($gridChars[$rr][$cc] === '@') {
                            $adjAt++;
                        }
                    }

                    if ($adjAt < 4) {
                        $toRemove[] = [$r, $c];
                    }
                }
            }

            if (empty($toRemove)) {
                break;
            }

            foreach ($toRemove as [$r, $c]) {
                $gridChars[$r][$c] = '.';
            }
        }

        $result = [];
        for ($r = 0; $r < $h; $r++) {
            $result[] = implode('', $gridChars[$r]);
        }
        return $result;
    }
}
