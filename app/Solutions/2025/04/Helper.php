<?php

namespace AoC\Solutions\Y2025\D04;

trait Helper
{
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
