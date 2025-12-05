<?php

declare(strict_types=1);

namespace AoC\Solutions\Y2015\D04;

use AoC\Solutions\BaseSolution;

use AoC\Testing\TestRunner;
use AoC\Traits\ParallelProcessing;

class B extends BaseSolution
{
    use ParallelProcessing;

    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(?string $input = null): int
    {
        $input = $input ?? $this->inputData;
        $target = '000000';
        $chunkSize = 1000000;
        $workers = $_ENV['workers'] ?? 8;
        $maxIterations = 100;

        for ($iteration = 0; $iteration < $maxIterations; $iteration++) {
            $offset = $iteration * $workers * $chunkSize;

            // Search in parallel chunks
            $result = $this->parallel(
                range(0, $workers - 1),
                function ($workerId) use ($input, $target, $chunkSize, $offset) {
                    $start = $offset + ($workerId * $chunkSize) + 1;
                    $end = $start + $chunkSize;

                    for ($i = $start; $i < $end; $i++) {
                        if (strcmp(substr(md5($input . $i), 0, 6), $target) === 0) {
                            return $i;
                        }
                    }
                    return null;
                },
                $workers
            );

            $validResults = array_filter($result, fn ($r) => $r !== null);

            if (!empty($validResults)) {
                return min($validResults);
            }
        }

        // Fallback if not found
        throw new \Exception("Solution not found");
    }

    public function test(TestRunner $t, string $testInput): void
    {
        $t->assertEquals(0, $this->solve(), 'Part B');
    }
}
