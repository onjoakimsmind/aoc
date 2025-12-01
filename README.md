# Advent of Code Wrapper (PHP)

A command-line wrapper for solving Advent of Code puzzles with automatic input fetching and organized structure.

## Setup

1. Install dependencies:

    ```bash
    composer install
    ```

2. Get your session cookie from adventofcode.com (browser dev tools → Application/Storage → Cookies)

3. Create a `.env` file from the example and add your session token:

    ```bash
    cp .env.example .env
    # Edit .env and add your session token
    ```

## Usage

### Workflow

The typical workflow for solving an AoC puzzle:

1. **Create the puzzle structure** (or use fetch to do this automatically)
2. **Add test input** from the puzzle's example
3. **Implement your solution** in `puzzle.php`
4. **Run tests** to verify with example data
5. **Run the solution** against real input

### Command Format

All commands support the convenient `YYYY/DD` format:

```bash
php aoc <command> YYYY/DD [options]
```

Examples:

- `php aoc create 2024/5` - Create day 5 of 2024
- `php aoc run 2024/1 -p A` - Run 2024 day 1, part A
- `php aoc test 2024/10` - Test 2024 day 10

### Commands

#### Create puzzle structure

Creates the directory and files for a new puzzle:

```bash
php aoc create                       # Create today's puzzle (defaults to 2025)
php aoc create 2024/5                # Create specific day

# Creates:
# - 2024/05/puzzle.php (from template)
# - 2024/05/test.txt (empty)
```

#### Fetch puzzle input

Downloads input from Advent of Code and creates puzzle structure:

```bash
php aoc fetch                        # Fetch today's input
php aoc fetch 2024/5                 # Fetch specific day

# Creates:
# - 2024/05/input.txt (downloaded from AOC)
# - 2024/05/puzzle.php (if doesn't exist)
# - 2024/05/test.txt (if doesn't exist)
```

#### Run tests

Runs your test function with input from `test.txt`:

```bash
php aoc test                         # Test today's puzzle (both parts)
php aoc test 2024/5                  # Test specific day
php aoc test 2024/5 -p A             # Test specific day, part A only
php aoc test 2024/5 -p B             # Test specific day, part B only

# Reads test input from: 2024/05/test.txt
# Runs the test() function in puzzle.php (or A/B.test() for specific part)
# Shows pass/fail with colored output
```

#### Run solution

Runs your solution with real input:

```bash
php aoc run                          # Run today's puzzle (both parts)
php aoc run 2024/5                   # Run specific day (both parts)
php aoc run 2024/5 -p A              # Run specific day, part A only
php aoc run 2024/5 -p B              # Run specific day, part B only

# Reads real input from: 2024/05/input.txt
# Runs solve() method on classes A and/or B
# Shows results with timing
```

## File Structure

```
aoc/
├── aoc                 # Main CLI script
├── .env                # Environment configuration (gitignored)
├── .env.example        # Example environment file
├── app/                # Application code
│   └── Commands/       # Command classes
├── bootstrap/          # Bootstrap files
├── stubs/              # File templates
│   └── Puzzle.php.stub # Template for new puzzles
└── YYYY/               # Year directories (e.g., 2024/)
    └── DD/             # Day directories (e.g., 01/, 02/)
        ├── puzzle.php  # Solution file (classes A and B)
        ├── input.txt   # Puzzle input (from AOC)
        └── test.txt    # Test input (from examples)
```

## Step-by-Step Example

Here's a complete example for solving Day 1 of 2024:

### 1. Create puzzle structure

```bash
php aoc create 2024/1
```

This creates:

- `2024/01/puzzle.php` (template with A, B classes and test function)
- `2024/01/test.txt` (empty - for test input)

### 2. Add test input

Copy the example input from the puzzle description to `2024/01/test.txt`:

```bash
# Example: if the puzzle shows this test case:
echo "1abc2
pqr3stu8vwx
a1b2c3d4e5f
treb7uchet" > 2024/01/test.txt
```

### 3. Implement solution

Edit `2024/01/puzzle.php` and implement the `solve()` methods:

```php
class A {
    public function solve(): int {
        // Your solution for part A
        return $result;
    }
}

class B {
    public function solve(): int {
        // Your solution for part B
        return $result;
    }
}

function test(TestRunner $t, string $testInput): void {
    $t->assertEquals(142, (new A($testInput))->solve(), 'Part A');
    $t->assertEquals(281, (new B($testInput))->solve(), 'Part B');
}
```

### 4. Run tests

```bash
php aoc test 2024/1
# ✓ All tests passed! (2/2)
```

### 5. Fetch real input and run

```bash
php aoc fetch 2024/1          # Downloads input.txt
php aoc run 2024/1            # Run your solution
# Part A: 54388 (took 2.45ms)
# Part B: 53515 (took 3.12ms)
```

## Solution Format

Each day's solution uses namespaces and defines two classes `A` and `B`, plus a `test()` function:

```php
<?php

declare(strict_types=1);

namespace Year2024\Day01;

use Aoc\Testing\TestRunner;

class A
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        // Your solution here
        return $result;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        // Tests for part A only
        $t->assertEquals(expected, (new A($testInput))->solve(), 'Part A description');
    }
}

class B
{
    private string $inputData;

    public function __construct(string $inputData)
    {
        $this->inputData = trim($inputData);
    }

    public function solve(): int
    {
        // Your solution here
        return $result;
    }

    public function test(TestRunner $t, string $testInput): void
    {
        // Tests for part B only
        $t->assertEquals(expected, (new B($testInput))->solve(), 'Part B description');
    }
}

function test(TestRunner $t, string $testInput): void
{
    // Test input is read from test.txt file
    // Run tests for both parts
    (new A($testInput))->test($t, $testInput);
    (new B($testInput))->test($t, $testInput);
}
```

**Namespace Convention:**

- Format: `Year{YYYY}\Day{DD}`
- Examples:
  - `Year2024\Day01` for 2024/01
  - `Year2024\Day25` for 2024/25
  - `Year2023\Day15` for 2023/15
- Namespaces are automatically generated by `create` and `fetch` commands

## Testing Framework

### Test Input Files

Tests read input from the `test.txt` file in each day's directory:

```
2024/01/
├── puzzle.php   # Your solution
├── input.txt    # Real puzzle input (from AOC)
└── test.txt     # Test input (from puzzle examples)
```

### TestRunner API

The `TestRunner` class provides assertion methods:

```php
function test(TestRunner $t, string $testInput): void {
    // Compare values
    $t->assertEquals(expected, actual, 'Description');

    // Boolean assertions
    $t->assertTrue($value > 0, 'Value should be positive');
    $t->assertFalse(empty($data), 'Data should not be empty');
}
```

### Test Output

**When all tests pass:**

```
Running tests for 2024 day 1...
✓ All tests passed! (3/3)
```

**When tests fail:**

```
Running tests for 2024 day 1...
✗ 1 test(s) failed! (2/3 passed)

Failure 1: Part B calculation
  Expected: 281
  Actual:   142
```

### Separate Testing

Each part has its own `test()` method, allowing you to test them independently:

```bash
php aoc -p A test    # Only runs A::test()
php aoc -p B test    # Only runs B::test()
php aoc test         # Runs both (via main test() function)
```

This is useful when:

- Part A is complete but Part B isn't ready
- You want to focus on debugging one specific part
- Parts have different test scenarios

### Tips

- Add multiple assertions to test edge cases
- Use descriptive messages for each assertion
- Test with the exact examples from the puzzle description
- Run tests frequently while developing your solution
- Test each part separately as you develop them
