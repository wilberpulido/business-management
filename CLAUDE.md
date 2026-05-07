# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Contexto

**Business Management** es un administrador de negocios flexible orientado a comercios (restaurantes, panaderías, charcuterías, etc.). Permite gestionar una o múltiples sucursales desde una sola cuenta.

### Visión general
- **Multi-empresa / Multi-sucursal**: los datos están aislados por empresa. Cada empresa puede tener múltiples sucursales.
- **Suscripciones por niveles** (futuro): el nivel base permite una sucursal; niveles superiores desbloquean más sucursales y funcionalidades.
- **Capas de gestión**:
  1. **Compras, uso y ventas** — inventario, BOM, movimientos, ventas *(alcance actual)*
  2. **Gastos operativos** — servicios, sueldos, gastos fijos *(futuro)*
  3. **Pagos y facturación** *(futuro)*
  4. **Módulo de clientes** *(futuro)*
  5. **Versión restaurante** con rol mozo *(futuro)*

### Roles
| Rol | Acceso |
|---|---|
| `owner` | Todas las sucursales de su empresa |
| `branch_manager` | Su sucursal asignada |
| `cashier` | Operaciones de caja en su sucursal |

Los roles se gestionan con **Spatie Laravel Permission** (tablas `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`).

---

## Alcance — Etapa 1: Compras, Uso y Ventas

### Productos y catálogo
- Los productos tienen tipo (`raw_material`, `intermediate`, `finished`) y unidad de medida.
- Cada producto tiene un **precio base** en catálogo. Los cambios de precio generan un historial (`product_price_history`).
- **Unidades de medida**: catálogo fijo definido por el sistema. Soporta **conversiones custom** (ej: 1 caja = 12 unidades).
- Los productos pueden o no manejar **lotes con fecha de vencimiento** (configurable por producto).

### BOM (Bill of Materials)
- Los productos `finished` e `intermediate` pueden tener una receta (`product_compositions`).
- Al vender un producto con BOM, el sistema **descuenta automáticamente** los ingredientes del inventario (**FEFO** cuando hay lotes).
- Al registrar una venta se puede **excluir ingredientes específicos** del BOM (ej: "sin cebolla"), lo cual omite el descuento de ese componente.

### Combos
- Un combo es un grupo de productos vendidos juntos a un precio especial.
- Los combos tienen su **propio BOM** independiente.
- Al vender un combo se descuentan los componentes de su BOM del inventario.

### Promociones
- Tabla `promotions` relacionada a un producto o combo con descuento (porcentaje o monto fijo).
- Configurables por: día de semana, rango de fechas, rango de horas (happy hour).
- El propietario configura si las promociones son **apilables o no**.

### Inventario y movimientos
- Tabla `inventories`: stock actual por sucursal y producto.
- Tabla `inventory_movements`: registro de todos los movimientos con tipos:
  - `in` — ingreso de mercancía (registra costo unitario de compra)
  - `out` — salida por venta
  - `adjustment` — ajuste manual
  - `waste` — merma/desperdicio
- Todos los movimientos admiten un campo `notes` para observaciones.
- El ingreso de la etapa 1 es un movimiento `in` simple. Diseñado para escalar a órdenes de compra a proveedores.

### Ventas
- Ventas a **clientes anónimos** en esta etapa (sin facturación).
- Una venta tiene ítems de productos y/o combos.
- Los descuentos se aplican **a nivel de venta** (porcentaje o monto fijo).
- Diseño abierto para integrar módulo de clientes en el futuro.

## Docker / Sail

El proyecto usa **Laravel Sail** (Docker). El archivo de configuración es `compose.yaml`.

### Servicios
| Servicio | Puerto |
|---|---|
| App (PHP 8.5) | `APP_PORT` (default 8099) |
| MySQL 8.4 | `FORWARD_DB_PORT` (default 3306) |
| Redis | `FORWARD_REDIS_PORT` (default 6379) |
| Meilisearch | `FORWARD_MEILISEARCH_PORT` (default 7700) |
| Mailpit | `FORWARD_MAILPIT_PORT` (default 1025), dashboard 8025 |
| Selenium | — |

### Comandos Sail
```bash
./vendor/bin/sail up -d        # levantar contenedores en background
./vendor/bin/sail down         # bajar contenedores
./vendor/bin/sail artisan ...  # correr comandos artisan dentro del contenedor
./vendor/bin/sail composer ... # composer dentro del contenedor
./vendor/bin/sail npm ...      # npm dentro del contenedor
```

> Si `vendor/` no existe aún, instalar dependencias primero en el host con `composer install` antes de usar Sail.

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

## Plans

Los planes se guardan en `.claude/plans/` dentro del proyecto.

### Convenciones de nombre
Seguir el mismo patrón que las migraciones de Laravel:
```
YYYY_MM_DD_HHMMSS_nombre-del-plan.md
```
El timestamp garantiza el orden cuando se crean varios planes el mismo día.

### Estructura de cada plan
- **Redactados en español.**
- Sección de **Contexto** al inicio: qué módulo cubre, modelos involucrados, rutas y permisos requeridos.
- Contenido organizado en **secciones** (ej: Rutas y Permisos, Funcionalidad X, Tests).
- Dentro de cada sección: **grupos funcionales** con sub-pasos técnicos.
- Cada paso usa una casilla `[ ]` que se marca `[x]` al completarse.
- Los pasos técnicos incluyen: nombre de clase, ruta, método, campos y reglas de validación relevantes.
- Los **tests** son pasos dentro del mismo plan, en una sección final.

### Flujo de trabajo
1. Se diseña y escribe el plan.
2. El plan es **revisado y aprobado por el usuario** antes de cualquier implementación.
3. Solo tras la aprobación se comienza a implementar siguiendo **TDD**:
   a. Escribir los tests del paso (deben fallar).
   b. Implementar el código mínimo para que pasen.
   c. Marcar `[x]` en el plan y pasar al siguiente paso.

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
