<?php

declare(strict_types=1);

namespace AoC\Commands;

use Codedungeon\PHPCliColors\Color;

class RunCommand extends Command
{
    private ?string $part;
    private bool $runAllDays;

    public function __construct(int $year, int $day = 0, ?string $part = null, bool $runAllDays = false)
    {
        parent::__construct($year, $day);
        $this->part = $part;
        $this->runAllDays = $runAllDays;
    }

    public function execute(): int
    {
        if ($this->runAllDays) {
            return $this->runAllDays();
        }

        $dayDir = $this->getDayDirectory();
        $inputPath = $this->getInputPath();

        if (!file_exists($inputPath)) {
            echo Color::RED . "Error: " . Color::RESET . "Input file not found at {$inputPath}\n";
            echo "Run: " . Color::YELLOW . "php aoc fetch {$this->year}/{$this->day}" . Color::RESET . " to download input\n";
            return 1;
        }

        $input = file_get_contents($inputPath);
        $parts = $this->part ? [$this->part] : ['A', 'B'];

        echo Color::CYAN . "Running {$this->year} day {$this->day}";
        if ($this->part) {
            echo " (part {$this->part})";
        }
        echo "...\n" . Color::RESET;

        $namespace = sprintf('AoC\\Solutions\\Y%d\\D%02d', $this->year, $this->day);

        foreach ($parts as $part) {
            $partFile = $dayDir . "/{$part}.php";
            if (!file_exists($partFile)) {
                echo Color::RED . "Error: " . Color::RESET . "File not found: {$partFile}\n";
                return 1;
            }

            // Load any helper/trait files in the same directory first (excluding A.php and B.php)
            foreach (glob(dirname($partFile) . '/*.php') as $file) {
                $basename = basename($file);
                if ($basename !== 'A.php' && $basename !== 'B.php') {
                    require_once $file;
                }
            }
            
            require_once $partFile;

            $className = $namespace . '\\' . $part;
            if (!class_exists($className)) {
                echo Color::RED . "Error: " . Color::RESET . "Class {$className} not found in {$partFile}\n";
                return 1;
            }

            $solver = new $className($input);
            $start = microtime(true);
            $result = $solver->solve();
            $duration = microtime(true) - $start;

            echo Color::LIGHT_PURPLE . "Part {$part}: " . Color::RESET;
            echo Color::BOLD . Color::GREEN . $result . Color::RESET;
            echo Color::DARK_GRAY . " (took " . number_format($duration * 1000, 2) . "ms)" . Color::RESET;
            echo "\n";
        }

        return 0;
    }

    private function runAllDays(): int
    {
        $solutionsDir = __DIR__ . '/../Solutions/' . $this->year;
        
        if (!is_dir($solutionsDir)) {
            echo Color::RED . "Error: " . Color::RESET . "No solutions found for year {$this->year}\n";
            return 1;
        }

        echo Color::CYAN . "Running all days for {$this->year}...\n" . Color::RESET;
        
        $days = [];
        foreach (glob($solutionsDir . '/*', GLOB_ONLYDIR) as $dayDir) {
            $day = (int) basename($dayDir);
            if ($day > 0 && $day <= 25) {
                $days[] = $day;
            }
        }
        sort($days);

        $totalTime = 0;
        foreach ($days as $day) {
            $dayObj = new RunCommand($this->year, $day, $this->part);
            $start = microtime(true);
            $result = $dayObj->execute();
            $duration = microtime(true) - $start;
            $totalTime += $duration;
            
            if ($result !== 0) {
                echo Color::YELLOW . "Day {$day} had errors, continuing...\n" . Color::RESET;
            }
            echo "\n";
        }

        echo Color::CYAN . "Total time: " . Color::RESET;
        echo Color::BOLD . number_format($totalTime * 1000, 2) . "ms" . Color::RESET . "\n";

        return 0;
    }
}
