# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Quick Start Commands

All commands run inside the Docker container via the `./dock` helper script. See `./dock help` for all available options.

### Docker & Container Access
- **Start services**: `./dock up` — build and start Docker containers
- **Stop services**: `./dock down` — stop Docker containers
- **SSH into container**: `./dock ssh` — interactive bash session (as laravel user)
- **SSH as root**: `./dock ssh app` — bash session with root privileges
- **Run command**: `./dock run <command>` — run any Linux command in container

### Development
- **Via SSH**: `./dock ssh` then run `php artisan serve` and `npm run dev` in separate terminals
- **Or use composer script**: `./dock composer dev` — runs Laravel server + queue listener + logs + Vite concurrently
- **Frontend dev only**: `./dock yarn dev` — runs Vite dev server
- **View logs**: `./dock pa pail` — Laravel logs with `pail`

### Testing (via ./dock pa)
- **Run all tests**: `./dock pa test` (or `./dock pa pest`)
- **Run single test file**: `./dock pa test tests/Feature/Auth/RegistrationTest.php`
- **Run tests with coverage**: `./dock pa test --coverage`
- **Watch mode**: `./dock pa pest --watch`
- **Unit tests only**: `./dock pa test tests/Unit`
- **Feature tests only**: `./dock pa test tests/Feature`

### Code Quality (via ./dock)
- **PHP linting/fixing**: `./dock pa pint` — fixes code style issues
- **Frontend linting/fixing**: `./dock yarn lint` — ESLint auto-fix for React/TypeScript
- **Frontend formatting**: `./dock yarn format` — Prettier formatting for resources/
- **TypeScript checking**: `./dock yarn types` — check for type errors without emitting
- **Format check (no fix)**: `./dock yarn format:check`

### Database (via ./dock pa)
- **Run migrations**: `./dock pa migrate`
- **Rollback migrations**: `./dock pa migrate:rollback`
- **Reset database**: `./dock pa migrate:refresh` (or `:refresh --seed` with seeders)
- **Create migration**: `./dock pa make:migration create_table_name`
- **Access tinker**: `./dock pa tinker`

### Composer & Package Management (via ./dock)
- **Install dependencies**: `./dock composer install`
- **Require package**: `./dock composer require vendor/package`
- **Update packages**: `./dock composer update`
- **Install frontend deps**: `./dock yarn install`

## Architecture Overview

### Project Purpose
This is a **testing environment** for the `laravel-repository` package. It's a fresh Laravel 13 setup with React/Inertia to validate repository pattern implementation and package integration.

### Stack
- **Backend**: Laravel 13 with Pest testing framework
- **Frontend**: React 19 + Inertia.js + TailwindCSS + shadcn/ui (Radix)
- **Database**: PostgreSQL (via Docker)
- **Build**: Vite (frontend), Laravel built-in (backend)
- **API Integration**: Repository pattern with abstracted interfaces

### Key Architectural Patterns

#### Repository Pattern Integration
The `laravel-repository` package is mounted locally at `/var/www/laravel-repository` (mapped from `../laravel-repository` in compose.yml). This is configured in `composer.json` as a path repository with symlink enabled:
```json
"repositories": [{
  "type": "path",
  "url": "/var/www/laravel-repository",
  "options": {"symlink": true}
}]
```

**Important**: When testing laravel-repository changes, the symlink should auto-reflect changes. If it doesn't, run `composer install` to re-sync.

#### Repository Structure
- **Base classes**: `app/Repositories/Base/Repository.php` (abstract base) and `RepositoryInterface.php` (contract)
- **Specific repositories**: `app/Repositories/Auth/UserRepository.php` with `UserRepositoryInterface.php`
- **Service provider**: `app/Providers/RepositoryServiceProvider.php` binds interfaces to implementations

Repositories wrap Eloquent models and enforce a consistent query abstraction.

#### Inertia + React Setup
- Controllers return Inertia responses: `Inertia::render('ComponentName', ['data' => $data])`
- React components live in `resources/js/Pages/` (page-level) and `resources/js/Components/` (reusable)
- Routes are auto-discovered in `resources/js/lib/route.ts` via `ziggy` package
- React handles all frontend interactivity; Laravel serves data

### Directory Structure
```
app/
  Http/Controllers/          # Route controllers; return Inertia responses
  Http/Middleware/           # Middleware (Inertia setup, appearance)
  Http/Requests/             # Form request validation
  Models/                    # Eloquent models
  Providers/                 # Service providers (Repository binding)
  Repositories/              # Repository pattern implementation

resources/js/
  Pages/                     # Full-page React components (Inertia)
  Components/                # Reusable React components
  lib/                       # Utilities and types

tests/
  Feature/                   # HTTP/integration tests (Pest)
  Unit/                      # Unit tests for business logic

config/                      # Laravel config files
database/
  migrations/                # Database schema
  factories/                 # Model factories for testing
  seeders/                   # Database seeders
```

### Testing Strategy
- **Pest PHP**: Modern, expressive test syntax (uses PHPUnit under the hood)
- **Feature tests**: HTTP requests, authentication flows, repository integration
- **Unit tests**: Business logic, utilities
- **Test database**: SQLite in-memory (`:memory:`) during test runs (see phpunit.xml)
- **Factories & seeders**: Use for test data generation

## Important Notes

### Docker-First Workflow
This is a **Docker-based** project. All development happens inside containers:
- **Never run commands directly** on your host machine
- Always use `./dock <command>` to execute commands in the container
- `./dock` script handles container startup, mounting, and command execution
- `.env` file must have `DOCKER_NAME` and `DOCKER_COMPOSE` set (checked into repo)

### ./dock Aliases
Quick reference for common `./dock` shortcuts:
- `./dock pa` → `./dock artisan` (run Laravel artisan commands)
- `./dock ssh` → interactive bash in container (as laravel user)
- `./dock run` → run arbitrary Linux commands in container
- `./dock composer` → run composer inside container
- `./dock yarn` → run yarn/npm inside container

### PHP Version & Environment
- **PHP 8.3+** required (running inside Docker)
- **Node.js** required for frontend tooling (running inside Docker)
- **Docker & Docker Compose** must be installed on host machine
- Environment variables in `.env` (copy from `.env.example`)

### Vite & Hot Module Reload
- Frontend assets are compiled via Vite (`./dock yarn dev` in development)
- Vite runs inside the container with hot module reload
- In production, build with `./dock yarn build` before deploying

### Common Gotchas
1. **Command execution**: All commands must use `./dock` prefix — never run PHP/Node commands directly on host
2. **Middleware order**: Check `bootstrap/app.php` if routes are behaving unexpectedly
3. **Inertia component mismatch**: React component names in `Inertia::render()` must match file names (case-sensitive)
4. **Repository binding**: Ensure `RepositoryServiceProvider` registers all interfaces/implementations
5. **Composer.json symlink**: Local `laravel-repository` package is symlinked; run `./dock composer install` if symlink breaks

### MCP Tools
This project has a code-review-graph knowledge graph enabled. Use MCP tools for codebase exploration:
- `semantic_search_nodes` — find functions, classes by name/keyword
- `query_graph pattern="callers_of"` — find who calls a function
- `detect_changes` — analyze impact of code changes
- `get_review_context` — get focused review context for PRs

See `.code-review-graph/` for graph data.
