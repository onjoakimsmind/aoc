<?php

declare(strict_types=1);

namespace AoC\Solutions;

use AoC\Testing\TestRunner;

abstract class BaseSolution
{
    protected string $input;

    public function __construct(string $input)
    {
        $this->input = trim($input);
    }

    abstract public function solve(): mixed;

    abstract public function test(TestRunner $t, string $testInput): void;

    public function getInput(): string
    {
        return $this->input;
    }

    protected function getLines(): array
    {
        return preg_split('/\R/', $this->input);
    }

    protected function getBlocks(string $delimiter = "\n\n"): array
    {
        return explode($delimiter, $this->input);
    }

    protected function getIntegers(): array
    {
        preg_match_all('/-?\d+/', $this->input, $matches);
        return array_map('intval', $matches[0]);
    }
}
