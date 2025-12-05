<?php

declare(strict_types=1);

namespace AoC\Solutions;

use AoC\Testing\TestRunner;

abstract class BaseSolution
{
    protected string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    abstract public function solve(): mixed;

    abstract public function test(TestRunner $t, string $testInput): void;

    public function getInput(): string
    {
        return $this->inputData;
    }

    protected function getLines(): array
    {
        return preg_split('/\R/', $this->inputData);
    }

    protected function getBlocks(string $delimiter = "\n\n"): array
    {
        return explode($delimiter, $this->inputData);
    }

    protected function getIntegers(): array
    {
        preg_match_all('/-?\d+/', $this->inputData, $matches);
        return array_map('intval', $matches[0]);
    }
}
