# 🛰️ Despliegue en cPanel — Enervisa (enervia.com.gt)

Guía completa para desplegar el sitio en hosting cPanel **sin acceso SSH**. Todos los pasos se realizan desde el **File Manager**, **MultiPHP Manager**, **MySQL Databases** y **Domains** de cPanel.

---

## 📋 Requisitos previos

- Acceso a cPanel con privilegios de administrador.
- Dominio `enervia.com.gt` apuntando al hosting.
- **PHP 8.3 o 8.4** habilitado (MultiPHP Manager).
- **MySQL 8** disponible.
- (Opcional) **API Key de Resend** con el dominio `enervia.com.gt` verificado.
- Certificado SSL activo (Let's Encrypt / AutoSSL).

---

## 🧭 Resumen de la estrategia

Como cPanel normalmente **no permite cambiar el Document Root**, el despliegue usa el esquema "**Laravel dentro de public_html**":

```
/home/<user>/public_html/              ← Document Root (= public/ de Laravel)
    ├── index.php                      ← modificado para apuntar a ../app_private
    ├── .htaccess
    ├── build/, images/, storage/, favicon.png, robots.txt ...
    └── app_private/                   ← resto de la app (app, config, vendor, etc.)
        ├── app/
        ├── bootstrap/
        ├── config/
        ├── database/
        ├── resources/
        ├── routes/
        ├── storage/
        ├── vendor/
        ├── .env
        ├── artisan
        └── composer.json
```

> Si tu hosting **sí permite** cambiar el Document Root, simplemente sube todo el repo a `/home/<user>/enervisa_app/` y apunta el Document Root del dominio a `/home/<user>/enervisa_app/public`. Los demás pasos son idénticos.

---

## 🏗️ Paso 1 — Preparar el paquete local

En tu equipo, dentro del repo clonado:

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

Esto genera `vendor/` y `public/build/` listos para producción.

Comprime **todo el contenido del proyecto** (no la carpeta contenedora) en un `.zip`:

```bash
zip -r enervisa.zip . -x "node_modules/*" ".git/*" ".env"
```

---

## ☁️ Paso 2 — Subir a cPanel

1. Entra en **File Manager** → `public_html/`.
2. Si hay archivos previos (index.html de bienvenida, cgi-bin, etc.) muévelos o elimínalos.
3. Sube `enervisa.zip` y usa **Extract** dentro de `public_html/`.
4. Crea la carpeta `app_private/` al lado de `public/`.
5. Mueve **todo lo que NO está dentro de `public/`** (app, bootstrap, config, database, resources, routes, storage, vendor, artisan, composer.json, etc.) hacia `app_private/`.
6. Mueve el **contenido** de `public/` a la raíz de `public_html/` (no la carpeta, su contenido).
7. Elimina la carpeta `public/` ya vacía.

Estructura final esperada:

```
public_html/
├── .htaccess
├── index.php
├── favicon.png
├── robots.txt
├── build/
├── images/
├── storage/                 ← carpeta real (no symlink), inicialmente vacía
└── app_private/
    ├── app/  bootstrap/  config/  database/  resources/  routes/  storage/  vendor/
    ├── .env  artisan  composer.json  ...
```

---

## 🧩 Paso 3 — Ajustar `index.php` y `bootstrap/app.php`

Edita `public_html/index.php`:

```php
// ANTES
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// DESPUÉS
require __DIR__.'/app_private/vendor/autoload.php';
$app = require_once __DIR__.'/app_private/bootstrap/app.php';
```

(Si Laravel 12 solo tiene la variante `require_once __DIR__.'/../bootstrap/app.php';`, actualiza ambos a `__DIR__.'/app_private/...'`).

No se requiere editar `bootstrap/app.php` — usa rutas relativas internamente.

---

## ⚙️ Paso 4 — Configurar `.env`

En `public_html/app_private/.env` pega y ajusta:

```env
APP_NAME=Enervisa
APP_ENV=production
APP_KEY=base64:GENERA_UNA_NUEVA
APP_DEBUG=false
APP_URL=https://enervia.com.gt

APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_ES

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=cpaneluser_enervisa
DB_USERNAME=cpaneluser_enervisa_user
DB_PASSWORD=<password-seguro>
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci

BROADCAST_CONNECTION=log
CACHE_STORE=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=log
# Cuando tengas Resend activo:
# MAIL_MAILER=resend
# RESEND_API_KEY=re_xxxxxxxxxxxxxxxxxxxxx
MAIL_FROM_ADDRESS="contacto@enervia.com.gt"
MAIL_FROM_NAME="Enervisa"

VITE_APP_NAME=Enervisa
```

### Generar `APP_KEY`

Desde tu equipo local:

```bash
php artisan key:generate --show
```

Copia la cadena `base64:...` al `.env` en cPanel.

---

## 🗄️ Paso 5 — Crear la base de datos

1. cPanel → **MySQL Databases**.
2. Crea una base: `cpaneluser_enervisa`.
3. Crea un usuario: `cpaneluser_enervisa_user` con password fuerte.
4. **Asigna el usuario a la base con `ALL PRIVILEGES`**.
5. Copia los datos en el `.env`.

---

## 🧬 Paso 6 — Ejecutar migraciones

### Opción A · Con Terminal (si tu hosting lo ofrece)

```bash
cd ~/public_html/app_private
php artisan config:clear
php artisan migrate --force
```

### Opción B · Sin Terminal (importar SQL)

1. Desde local ejecuta `php artisan migrate --force` apuntando a un MySQL limpio y luego **exporta** el dump:
   ```bash
   mysqldump -u root -p laravel_local > enervisa_schema.sql
   ```
2. En cPanel → **phpMyAdmin** → selecciona la DB → pestaña **Importar** → sube `enervisa_schema.sql`.

> Alternativamente, crea un endpoint temporal `/install` en `routes/web.php` que llame `Artisan::call('migrate', ['--force' => true]);` y elimínalo después. Úsalo solo con IP restringida.

---

## 🔐 Paso 7 — Permisos

Desde **File Manager** → clic derecho → **Change Permissions**:

| Ruta | Permisos |
|------|----------|
| `app_private/storage/` (recursivo) | `755` (carpetas) / `644` (archivos) |
| `app_private/bootstrap/cache/` | `775` |
| `storage/` (en `public_html/`) | `755` |
| `storage/gallery/` y `storage/gallery/thumbs/` | `755` |
| `.env` | `600` |

> En algunos hostings LiteSpeed requiere `755` en vez de `775` para que el usuario PHP pueda escribir.

---

## 🧱 Paso 8 — Verificar `.htaccess`

El `.htaccess` ya incluido en la raíz (`public_html/.htaccess`) contiene las reglas de Laravel + el handler de PHP de cPanel. Revisa que **exista** y **no esté duplicado** en niveles superiores:

```apache
# Forzar el handler de PHP moderno (ajusta versión si tu hosting usa php83)
AddHandler application/x-httpd-ea-php84___lsphp .php .php84

DirectoryIndex index.php index.html

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

> ⚠️ **Si ves que los `.php` se descargan en vez de ejecutarse**, abre `/home/<user>/.htaccess` y **elimina** cualquier `AddHandler application/x-httpd-php71 .php` o handlers obsoletos heredados.

---

## 🖼️ Paso 9 — Carpeta de imágenes

Este proyecto **no usa** `php artisan storage:link`. El disco `public` apunta directamente a `public_html/storage/` (ver `config/filesystems.php`).

1. Crea manualmente:
   ```
   public_html/storage/gallery/
   public_html/storage/gallery/thumbs/
   ```
2. Permisos `755` (o `775` según el servidor).
3. Al subir un proyecto desde `/admin/gallery`, los archivos aparecerán automáticamente aquí.

---

## 🧼 Paso 10 — Caché de producción

Si tienes Terminal:

```bash
cd ~/public_html/app_private
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Sin Terminal: sáltalo. Laravel funciona sin caché (un poco más lento). Si lo habías cacheado antes y ahora te da errores, borra:

```
app_private/bootstrap/cache/config.php
app_private/bootstrap/cache/routes-v7.php
app_private/bootstrap/cache/services.php
```

---

## 🧪 Paso 11 — Verificación

1. `https://enervia.com.gt` → debe cargar la home con estilos e imágenes.
2. `https://enervia.com.gt/admin/login` → loguea con `admin@enervisa.com` / `enervisa2026`.
3. `https://enervia.com.gt/#contacto` → envía el formulario.
4. `app_private/storage/logs/laravel.log` → debe contener el correo renderizado (si `MAIL_MAILER=log`).

---

## 🛠️ Solución de problemas frecuentes

| Síntoma | Causa probable | Solución |
|---------|---------------|----------|
| `.php` se **descarga** | Handler heredado de `/home/<user>/.htaccess` (php71) | Borrar esa línea en el `.htaccess` padre |
| `500 Internal Server Error` | Permisos o `.env` mal | Revisar `storage/logs/laravel.log`, permisos `755`, `APP_KEY` presente |
| `SQLSTATE[HY000] [1044] Access denied` | Usuario sin privilegios | Reasignar usuario → DB con **ALL PRIVILEGES** |
| Estilos no cargan | `public/hot` residual de Vite | Borrar `public_html/hot` si existe |
| Imágenes 404 | Archivos no están en `public_html/storage/gallery/` | Subir al path correcto o recrear desde `/admin/gallery` |
| Correos no llegan | `MAIL_MAILER=log` o dominio no verificado en Resend | Cambiar a `resend` y verificar dominio |
| `Class "Resend..." not found` | Falta `composer install --no-dev` | Reinstalar dependencias y volver a subir `vendor/` |

---

## ✅ Checklist final

- [ ] `public_html/` contiene los archivos de `public/` (index.php, .htaccess, build/, images/…)
- [ ] `public_html/app_private/` contiene app, vendor, config, etc.
- [ ] `index.php` apunta a `./app_private/vendor/autoload.php` y `./app_private/bootstrap/app.php`
- [ ] `.env` configurado con `APP_KEY`, credenciales MySQL y URL `https://enervia.com.gt`
- [ ] Base de datos creada con usuario asignado (`ALL PRIVILEGES`)
- [ ] Migraciones ejecutadas
- [ ] Permisos correctos en `storage/` y `bootstrap/cache/`
- [ ] `public_html/storage/gallery/` y `.../thumbs/` existen con `755`
- [ ] SSL activo
- [ ] Página principal + panel admin + formulario de contacto funcionando
- [ ] (Opcional) Resend activo y dominio verificado

---

## 📞 Soporte

Para diagnóstico:
1. `app_private/storage/logs/laravel.log` — log de errores de Laravel.
2. cPanel → **Errors** — últimos errores del servidor.
3. cPanel → **Metrics → Errors** — historial.
