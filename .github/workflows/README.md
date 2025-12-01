# GitHub Actions Workflow

## Advent of Code Automation

This workflow automatically:
1. Installs PHP and dependencies
2. Downloads puzzle input using `AOC_SESSION` secret
3. Runs tests (if test.txt exists)
4. Runs the solution and displays results

## Setup

1. Add your AOC session token as a repository secret:
   - Go to: Repository → Settings → Secrets and variables → Actions
   - Click "New repository secret"
   - Name: `AOC_SESSION`
   - Value: Your session token from adventofcode.com cookies

## Usage

### Automatic (on push)
Runs on every push to main/master branch with current date (December only)

### Manual Trigger
1. Go to Actions tab
2. Select "Advent of Code" workflow
3. Click "Run workflow"
4. Enter Year and Day
5. Click "Run workflow"

## Finding Your Session Token

1. Go to https://adventofcode.com
2. Log in
3. Open browser DevTools (F12)
4. Go to Application/Storage → Cookies
5. Find `session` cookie
6. Copy the value (long hexadecimal string)
