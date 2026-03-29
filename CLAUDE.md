# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Contexto

Este proyecto es un boilerplate. Debe ser una base sólida de herramientas sin agregar lógica de negocios.

## Stack

- **Laravel 12** + **Livewire 4** + **Laravel Fortify** (auth)
- **Tailwind CSS 4** + **Vite 7**
- **SQLite** by default (configurable via `DB_CONNECTION`)
- **PHPUnit 11** for testing, **Laravel Pint** for code style

## Commands

### Initial setup
```bash
composer setup
```
Runs: `composer install`, copies `.env`, generates app key, migrates, `npm install`, `npm run build`.

### Development (all-in-one)
```bash
composer dev
```
Concurrently runs: PHP dev server, queue worker, Pail log viewer, and Vite dev server.

### Testing
```bash
composer test              # clear config + run all tests
php artisan test --filter TestName   # run a single test
```

### Frontend
```bash
npm run dev    # Vite dev server
npm run build  # production build
```

### Code style
```bash
./vendor/bin/pint
```

### Custom artisan commands
```bash
php artisan lang:sort            # sort all translation files alphabetically
php artisan lang:sort es         # sort a specific locale only
```

## Architecture

### Routing
Routes use Livewire's `Route::livewire()` helper with namespaced component names:
```php
Route::livewire('/', 'pages::guest.landing')->name('guest.landing');
```
The `pages::` prefix maps to `resources/views/pages/`. Auth routes (`/login`, `/register`) are handled by Fortify and configured in `FortifyServiceProvider` to use `pages::guest.auth.login` and `pages::guest.auth.register`.

### Views
Blade views follow a namespace convention under `resources/views/`:
- `pages/` — full-page Livewire components (routable)
- `components/` — reusable Blade components (layouts, UI, forms, marketing sections)
- `layouts/` — base HTML layouts (`app.blade.php` includes Vite assets, Livewire scripts, and dark mode initialization)

### Livewire Components
PHP Livewire component classes live in `app/Livewire/`. Currently only `Forms/auth/LoginForm.php` exists as a form object used by the login page.

### Authentication
Fortify handles auth. Action classes in `app/Actions/Fortify/` define user creation, password update, profile update, and password reset logic. Rate limiting (5 req/min) is configured in `FortifyServiceProvider`.

### Translations
Two layers of translations:
- `lang/{locale}/` — PHP array files (e.g., `lang/en/`, `lang/es/`)
- `lang/{locale}.json` — JSON files for short translation keys

Supported locales: `en`, `es`. Use `php artisan lang:sort` after adding/editing translation keys.

**Convention for organizing translations:**
- **Common/shared keys** (buttons, labels, general UI) → `lang/{locale}.json`
- **Page-specific keys** → `lang/{locale}/{page_name}.php` (e.g., `lang/es/landing.php`)
- **Model-related keys** → `lang/{locale}/{model_name}.php` (e.g., `lang/es/user.php`)

### Dark Mode
Dark mode is initialized inline in `layouts/app.blade.php` via `localStorage.theme` before page render to avoid flash. The `<x-ui.theme-toggle />` component handles toggling.

### Responsive Design
Use **mobile-first** approach with Tailwind CSS. Write base styles for mobile and use `sm:`, `md:`, `lg:`, `xl:` prefixes to scale up for larger screens.

### Dark Mode
Every view must support dark mode. Use Tailwind's `dark:` prefix for all color and background styles.
