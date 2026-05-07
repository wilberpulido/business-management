# M1 · Configuración de Empresa

Plan de implementación del módulo 1 del plan general (`2026_04_12_184135_stage-1-owner.md`).

## Contexto

El dueño debe poder ver y editar los datos generales de su empresa, y gestionar las monedas que acepta el negocio. Este módulo no requiere sucursal activa (modo global). Modelos involucrados: `Enterprise`, `Currency` (pivot `currency_enterprise`).

**Rutas (implementadas con nombres en inglés):**
- `GET /app/company` — Company profile
- `GET /app/company/currencies` — Currency management

**Permisos requeridos:** `enterprises.view`, `enterprises.update`

---

## Sección 1: Rutas y Permisos

- [x] Registrar rutas en `routes/web.php` dentro del grupo `auth`:
  - `Route::livewire('/app/company', Profile::class)->name('company.profile')`
  - `Route::livewire('/app/company/currencies', Currencies::class)->name('company.currencies')`
- [x] Verificar que los permisos `enterprises.view` y `enterprises.update` existen en `database/seeders/RoleAndPermissionSeeder.php` y están asignados al rol `owner`

---

## Sección 2: Perfil de Empresa

**Funcionalidad:** el dueño ve y edita los datos generales de su empresa.

- [x] Crear clase Livewire `app/Livewire/Pages/App/Company/Profile.php`
  - `mount()`: carga el `Enterprise` del usuario autenticado (`auth()->user()->enterprise`)
  - Propiedades: `trade_name`, `business_name`, `tax_id`, `address`, `city`, `state`, `country`, `phone`, `email`, `website`
  - Método `save()`: valida, actualiza y dispara evento de toast de éxito
  - Reglas de validación: `trade_name` requerido, `email` formato válido (nullable), resto opcionales
  - Proteger con `$this->authorize('enterprises.update')`
- [x] Crear vista `resources/views/pages/app/company/profile.blade.php`
  - Formulario con todos los campos del modelo `Enterprise`
  - Botón guardar con indicador de carga (`wire:loading`)
  - Toast / notificación de éxito al guardar

---

## Sección 3: Gestión de Monedas

**Funcionalidad:** el dueño asocia/desasocia monedas del catálogo y define la moneda predeterminada.

- [x] Crear clase Livewire `app/Livewire/Pages/App/Company/Currencies.php`
  - `mount()`: carga las monedas activas de la empresa vía computed property `currencyList`
  - Método `attach(int $currencyId)`: asocia la moneda vía pivot `currency_enterprise`; si es la primera, la marca como predeterminada automáticamente
  - Método `detach(int $currencyId)`: valida que no sea la predeterminada antes de desasociar; si lo es, retorna error con mensaje al usuario
  - Método `setDefault(int $currencyId)`: quita `is_default` de la anterior y lo asigna a la nueva dentro de una transacción DB
- [x] Crear vista `resources/views/pages/app/company/currencies.blade.php`
  - Lista de todas las monedas del catálogo con indicador de estado (activa / inactiva para este negocio)
  - Badge "Predeterminada" en la moneda con `is_default = true`
  - Botones contextuales por moneda: "Agregar" (si inactiva), "Quitar" (si activa y no predeterminada), "Marcar como predeterminada" (si activa y no lo es)
  - Mensaje de error inline si se intenta quitar la predeterminada

---

## Sección 4a: Correcciones post-implementación

- [x] `Profile.$enterprise` y `Currencies.$enterprise` cambiados a `?Enterprise = null` para evitar TypeError cuando el usuario aún no tiene empresa configurada
- [x] Ambos componentes redirigen a `dashboard` en `mount()` si `auth()->user()->enterprise` es null
- [x] Dashboard actualizado con CTAs de setup:
  - Si no hay empresa: card indigo con botón "Configurar empresa" → `/app/company`
  - Si hay empresa pero sin sucursales: card amber con mensaje (botón activo en M2)
- [x] Keys de traducción `ui.dashboard.setup.*` añadidas a `lang/en/ui.php` y `lang/es/ui.php`

---

## Sección 6: Refactor a tabs

**Motivación:** las monedas estaban implementadas como ruta separada (`/app/company/currencies`) sin forma de llegar a ellas desde la navegación. Se unifican perfil y monedas en una sola página con tabs para que la configuración de empresa sea un punto de entrada coherente.

**Cambios:**

- [x] Convertir `/app/company` en una página con dos tabs: **Perfil** y **Monedas**
  - Tab activo controlado via Alpine.js con URL sync via `history.pushState` (`?tab=profile` / `?tab=currencies`)
  - Componentes genéricos `x-ui.tabs` y `x-ui.tab-panel` (reutilizables en toda la app)
  - Cada tab renderiza su componente hijo Livewire (`company.enterprise-profile` y `company.enterprise-currencies`)
- [x] Eliminar la ruta `/app/company/currencies` de `routes/web.php` (queda absorbida por la página principal)
- [x] Eliminar el componente de página `app/Livewire/Pages/App/Company/Currencies.php` (reemplazado por child `EnterpriseCurrencies`)
- [x] Actualizar breadcrumb: ambos tabs muestran `Dashboard → Empresa` (sin tercer nivel)
- [x] Actualizar botones del dashboard para que apunten a `/app/company` (ya apuntan, no requiere cambio)

---

## Sección 5: Breadcrumb

**Funcionalidad:** navegación jerárquica en las páginas de empresa para orientar al usuario y permitirle volver a niveles anteriores.

- [x] Crear componente Blade `resources/views/components/ui/breadcrumb.blade.php`
  - Recibe prop `items`: array de `['label' => '...', 'route' => '...']`. El último item es el activo (sin enlace).
  - Separador visual entre items (ej: `/` o `›`)
  - Soporte dark mode
- [x] Agregar breadcrumb en `resources/views/livewire/company/enterprise-profile.blade.php`
  - Items: `Dashboard` → `Empresa`
- [x] Breadcrumb en currencies absorbido por el refactor a tabs (Sección 6)

---

## Sección 4: Tests

- [x] `test('owner can view company profile')` — componente carga con `trade_name` correcto en estado
- [x] `test('owner can update company data')` — `save()` actualiza el registro en BD con los nuevos datos
- [x] `test('user without permission cannot edit company')` — respuesta 403
- [x] `test('owner can attach currency')` — `attach()` crea registro en pivot `currency_enterprise`
- [x] `test('first attached currency is set as default')` — `is_default = true` en el pivot
- [x] `test('owner can detach non default currency')` — `detach()` elimina el registro del pivot
- [x] `test('cannot detach default currency')` — `detach()` sobre la predeterminada retorna error de validación
- [x] `test('owner can change default currency')` — `setDefault()` actualiza `is_default` correctamente en el pivot
