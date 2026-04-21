# AGENTS.md · Enervisa

> Contexto para agentes de IA (Copilot / Claude / Cursor) que trabajen en este repo.

## 🎯 Qué es este proyecto

Sitio web corporativo de **Enervisa** (<https://enervia.com.gt>), empresa guatemalteca de ingeniería eléctrica (generación, transmisión, subestaciones, solar, mantenimiento, consultoría).

Single-page marketing + panel admin ligero para gestionar servicios, galería de proyectos, mensajes de contacto y configuración general del sitio.

## 🧱 Stack y versiones

- **Laravel 12** (PHP 8.3+)
- **Blade + Tailwind CSS** (sin componentes JS frameworks)
- **Vite 8** (`npm run dev` / `npm run build`)
- **MySQL 8** en producción · **SQLite** en desarrollo local
- **Intervention Image v3** (miniaturas)
- **Three.js** (shader WebGL del hero)
- **Resend** (driver de correo en producción, `log` en dev)

## 📁 Convenciones del repo

```
app/
├── Http/Controllers/
│   ├── HomeController.php         # home + formulario de contacto
│   ├── AuthController.php         # login panel
│   └── Admin/                     # CRUD del panel (auth middleware)
├── Mail/
│   ├── ContactMessageSubmittedMail.php   # notifica al equipo interno
│   └── ContactMessageReceivedMail.php    # acuse al visitante
├── Models/
│   ├── Setting.php     # key-value con caché `settings.all`
│   ├── Service.php
│   ├── Gallery.php     # image_path + thumbnail_path
│   ├── ContactMessage.php
│   └── User.php
└── Services/ImageProcessor.php    # genera thumbnails al subir galería

resources/views/
├── home.blade.php
├── sections/          # hero.blade.php, inicio.blade.php, servicios, proyectos, contacto...
├── admin/             # panel (dashboard + CRUD)
├── emails/            # plantillas de correo
└── layouts/

resources/js/
├── app.js
├── shader.js          # Three.js hero
└── lightning-split.js # efecto de rayos

routes/web.php         # define todas las rutas (pocas, legibles)
```

## 🔑 Piezas clave que hay que conocer antes de editar

### 1. `Setting` (key-value cacheado)

Muchos textos del home vienen de la tabla `settings`:

```php
Setting::get('about_title', 'fallback')
```

**⚠️ Importante**: usa `Cache::rememberForever('settings.all', ...)`. Si insertas/actualizas por SQL directo (sin Eloquent), debes borrar la caché:
- `CACHE_STORE=file` → borrar `storage/framework/cache/data/*`
- `CACHE_STORE=database` → `TRUNCATE cache;`
- O guardar cualquier campo en `/admin/settings` (dispara `Cache::forget`)

Llaves conocidas: `about_title`, `about_text`, `stat_projects`, `stat_clients`, `stat_years`, `stat_team`, `contact_email`, `hero_*`, etc.

### 2. Filesystem sin `storage:link`

`config/filesystems.php` está modificado:
- Disco `public` apunta a `public_path('storage')` (no a `storage_path('app/public')`)
- Array `links` está vacío

Razón: el hosting cPanel no permite `php artisan storage:link`. Todas las subidas (galería) van directas a `public/storage/gallery/...`.

**Si vas a agregar otro disco público**, replica este patrón o documenta que requiere symlink.

### 3. Galería — `Gallery::getThumbnailUrlAttribute()`

```php
return Storage::url($this->thumbnail_path ?: $this->image_path);
```

Solo hace fallback si `thumbnail_path` **es null/vacío**, NO si el archivo físico no existe. Si el 404 aparece, revisar que el archivo esté en `public/storage/gallery/thumbs/`.

Naming: `ImageProcessor` genera `proyecto-{uniqid}.jpg` y `proyecto-{uniqid}-thumb.jpg`.

### 4. Formulario de contacto (`HomeController::contact`)

Flujo:
1. Valida + persiste en `contact_messages`.
2. Envía `ContactMessageSubmittedMail` a `Setting::get('contact_email', config('mail.from.address'))`.
3. Envía `ContactMessageReceivedMail` (acuse) al visitante.
4. Todo el bloque `Mail::to(...)->send(...)` está dentro de un `try/catch` que solo hace `Log::warning`. **Por eso los errores de envío son invisibles al usuario final** — siempre revisar `storage/logs/laravel.log` antes de cambiar algo relacionado con correos.

## 🚀 Ambientes

### Local
- `.env` con SQLite o MySQL
- `MAIL_MAILER=log` (no salen correos de verdad)
- `APP_DEBUG=true`
- `php artisan serve` + `npm run dev`

### Producción (cPanel, hosting actual)
- Path real: `/home2/asjcom/enervia.com.gt/` (raíz Laravel)
- Document root del dominio: `/home2/asjcom/enervia.com.gt/public/`
- **Sin acceso SSH** — todo se maneja por File Manager / phpMyAdmin
- `APP_DEBUG=false`, `LOG_LEVEL=error`
- `MAIL_MAILER=resend` + dominio verificado
- `CACHE_STORE=file`, `SESSION_DRIVER=file`
- DB: `asjcom_enervisa` / usuario `asjcom_enervisa_user`

Guía completa: [DEPLOYMENT.md](DEPLOYMENT.md).

## ⚠️ Cosas que NO hacer

- **No** asumir que `php artisan storage:link` existe en producción. No se usa.
- **No** editar código sobre `storage/app/public/` — el disco apunta a `public/storage/`.
- **No** exponer `APP_KEY`, `RESEND_API_KEY`, credenciales DB en commits. `.env*` está en `.gitignore`.
- **No** agregar comandos `post-install` de Composer que requieran red/binarios ausentes en cPanel (se rompe el `composer install` en servidor).
- **No** depender de `queue:work` — `QUEUE_CONNECTION=sync`.
- **No** cachear config (`config:cache`) en cPanel si vas a cambiar `.env` seguido — cada cambio requiere borrar `bootstrap/cache/config.php` manualmente.

## 🧪 Verificación rápida tras cambios

```bash
# Local
php artisan config:clear
php artisan serve
# Revisar storage/logs/laravel.log si algo falla
```

Si el cambio afecta:
- **Vistas/CSS/JS** → `npm run build` antes de subir `public/build/` a producción.
- **Migraciones** → ejecutar en local + exportar dump SQL para aplicar en phpMyAdmin (no hay terminal en cPanel).
- **Composer** → reinstalar y comprimir el `vendor/` afectado para subir por File Manager.

## 🔒 Seguridad / OWASP

- Formulario de contacto tiene validación Laravel (`required|email|max:...`) — **no** desactivar.
- Panel admin detrás de `auth` middleware.
- Passwords bcrypt (por defecto Laravel).
- No aceptar uploads sin pasar por `ImageProcessor` (redimensiona + valida MIME).
- CSRF activo por defecto — no añadir rutas POST sin token.

## 📬 Comunicación

Repo: <https://github.com/app-piums/Enervisa.git>
Dominio: <https://enervia.com.gt>
Contacto interno: `info@enervia.com.gt`
Remitente Resend: `contacto@enervia.com.gt` (dominio verificado)
