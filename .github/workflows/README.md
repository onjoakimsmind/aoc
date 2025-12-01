# GitHub Actions Workflow

## Advent of Code Automation

This workflow automatically:
1. Installs PHP and dependencies
2. Downloads puzzle input using `AOC_SESSION` secret
3. Runs tests (if test.txt exists)
4. Runs the solution and displays results

## Triggers

### Automatic (on push/PR)
The workflow **only runs** when files change in:
- `YYYY/DD/**` - Any puzzle directory (e.g., 2025/01/, 2024/12/)
- `app/**` - Core application code
- `composer.json` or `composer.lock` - Dependencies
- `.github/workflows/aoc.yml` - Workflow itself

**Examples that trigger:**
- ✅ Push to `2025/01/A.php` → Runs
- ✅ Push to `2025/12/input.txt` → Runs
- ✅ Push to `app/Commands/RunCommand.php` → Runs
- ❌ Push to `README.md` → Does NOT run
- ❌ Push to unrelated files → Does NOT run

### Manual Trigger
1. Go to Actions tab
2. Select "Advent of Code" workflow
3. Click "Run workflow"
4. Enter Year and Day
5. Click "Run workflow"

## Setup

1. Add your AOC session token as a repository secret:
   - Go to: Repository → Settings → Secrets and variables → Actions
   - Click "New repository secret"
   - Name: `AOC_SESSION`
   - Value: Your session token from adventofcode.com cookies

## Finding Your Session Token

1. Go to https://adventofcode.com
2. Log in
3. Open browser DevTools (F12)
4. Go to Application/Storage → Cookies
5. Find `session` cookie
6. Copy the value (long hexadecimal string)

## Date Detection

- **Manual run**: Uses your input values
- **Auto run in December**: Uses current date (e.g., Dec 1 → 2025/1)
- **Auto run other months**: Defaults to 2025/1

## Workflow Steps

1. Checkout code
2. Install PHP 8.4 + Composer dependencies
3. Create .env with AOC_SESSION
4. Determine year/day
5. Create puzzle files (if needed)
6. Fetch puzzle input
7. Run tests
8. Run solution
9. Display results

## Path Filter Details

The workflow uses GitHub's path filtering to only run when relevant files change:

```yaml
paths:
  - '[0-9][0-9][0-9][0-9]/[0-9][0-9]/**'  # Matches: 2025/01/, 2024/25/, etc.
  - 'app/**'                               # Matches: app/Commands/, app/Testing/, etc.
  - 'composer.json'                        # Dependencies
  - 'composer.lock'                        # Lock file
  - '.github/workflows/aoc.yml'            # Workflow itself
```

This ensures the workflow doesn't waste Actions minutes on unrelated changes like documentation updates! 🎉
