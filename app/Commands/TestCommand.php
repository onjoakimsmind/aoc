<?php

declare(strict_types=1);

namespace Aoc\Commands;

use Codedungeon\PHPCliColors\Color;

class TestCommand extends Command
{
    private ?string $part;

    public function __construct(int $year, int $day, ?string $part = null)
    {
        parent::__construct($year, $day);
        $this->part = $part;
    }

    public function execute(): int
    {
        $dayDir = $this->getDayDirectory();
        $testInputPath = $this->getTestInputPath();

        if (!file_exists($testInputPath)) {
            echo Color::RED . "Error: " . Color::RESET . "Test input file not found at {$testInputPath}\n";
            echo "Create a file with test input at: " . Color::YELLOW . $testInputPath . Color::RESET . "\n";
            return 1;
        }

        echo Color::CYAN . "Running tests for {$this->year} day {$this->day}";
        if ($this->part) {
            echo " (part {$this->part})";
        }
        echo "...\n" . Color::RESET;
        
        $testInput = file_get_contents($testInputPath);
        $runner = new \Aoc\Testing\TestRunner();
        
        $namespace = sprintf('Y%d\\D%02d', $this->year, $this->day);
        $parts = $this->part ? [$this->part] : ['A', 'B'];

        try {
            foreach ($parts as $part) {
                $partFile = $dayDir . "/{$part}.php";
                if (!file_exists($partFile)) {
                    echo Color::RED . "Error: " . Color::RESET . "File not found: {$partFile}\n";
                    return 1;
                }

                require_once $partFile;

                $className = $namespace . '\\' . $part;
                if (!class_exists($className)) {
                    echo Color::RED . "Error: " . Color::RESET . "Class {$className} not found\n";
                    return 1;
                }
                
                $instance = new $className($testInput);
                if (!method_exists($instance, 'test')) {
                    echo Color::RED . "Error: " . Color::RESET . "test() method not found in class {$part}\n";
                    return 1;
                }
                
                $instance->test($runner, $testInput);
            }
            
            $runner->printResults();
            return $runner->hasFailures() ? 1 : 0;
        } catch (\Throwable $e) {
            echo Color::BOLD . Color::RED . "✗ Test error: " . Color::RESET . $e->getMessage() . "\n";
            echo Color::DARK_GRAY . "  in {$e->getFile()}:{$e->getLine()}\n" . Color::RESET;
            return 1;
        }
    }
}
