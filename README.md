# Enervisa · Sitio Web Corporativo

Sitio web oficial de **Enervisa** ([enervia.com.gt](https://enervia.com.gt)), empresa especializada en soluciones de ingeniería eléctrica: generación, transmisión, subestaciones, energía solar fotovoltaica, mantenimiento predictivo y consultoría.

Construido sobre **Laravel 12 + Vite + Tailwind CSS** con panel administrativo, galería de proyectos, servicios dinámicos, formulario de contacto con notificaciones por correo (Resend) y efectos visuales WebGL (Three.js) en el hero.

---

## 🧱 Stack

| Capa | Tecnología |
|------|------------|
| Backend | Laravel 12 (PHP 8.3+) |
| Frontend | Blade + Tailwind CSS + Vite |
| Base de datos | MySQL 8 (producción) / SQLite (local) |
| Correo | Resend (producción) / log (desarrollo) |
| Imágenes | Intervention Image (miniaturas automáticas) |
| Efectos | Three.js (shader de rayos en hero) |

---

## 🚀 Instalación local

Requisitos: **PHP 8.3+**, **Composer 2**, **Node 20+**, **npm**.

```bash
git clone https://github.com/app-piums/Enervisa.git
cd Enervisa

# Dependencias
composer install
npm install

# Variables de entorno
cp .env.example .env
php artisan key:generate

# Base de datos (SQLite por defecto)
touch database/database.sqlite
php artisan migrate --seed

# Link de storage (solo desarrollo)
php artisan storage:link

# Desarrollo
npm run dev          # en una terminal (Vite)
php artisan serve    # en otra terminal
```

Visita <http://127.0.0.1:8000>.

### Credenciales por defecto (panel admin)

Ruta: `/admin/login`

```
usuario: admin@enervisa.com
clave:   enervisa2026
```

> Cambia la clave desde el panel antes de exponer a producción.

---

## 🗂️ Estructura relevante

```
app/
├── Http/Controllers/          # HomeController, Admin\*
├── Mail/                      # ContactMessageSubmitted / Received
├── Models/                    # Gallery, Service, Setting, ContactMessage
└── Services/ImageProcessor.php
database/
├── migrations/                # settings, services, galleries, contact_messages
└── seeders/                   # GallerySeeder, ServiceSeeder
resources/
├── js/                        # app.js, shader.js (Three.js), lightning-split.js
├── css/app.css                # Tailwind
└── views/
    ├── home.blade.php
    ├── admin/                 # dashboard + CRUD servicios/galería/mensajes
    ├── sections/              # hero, servicios, proyectos, contacto...
    └── emails/                # plantillas de correo
routes/web.php
public/
├── images/logo.png, favicon.png
└── storage/                   # imágenes cargadas (producción)
```

---

## 🖼️ Galería de proyectos

- Las subidas caen en `public/storage/gallery/` (imagen principal) y `public/storage/gallery/thumbs/` (miniatura generada automáticamente).
- El disco `public` de Laravel está configurado para escribir **directamente** en `public/storage` — ver [`config/filesystems.php`](config/filesystems.php). Esto evita depender de `php artisan storage:link` en cPanel sin SSH.

---

## ✉️ Formulario de contacto

Al enviar se:
1. Persiste el mensaje en `contact_messages`.
2. Envía correo interno al equipo (`ContactMessageSubmittedMail`).
3. Envía acuse al cliente (`ContactMessageReceivedMail`).

En desarrollo `MAIL_MAILER=log` deja los correos en `storage/logs/laravel.log`. En producción se activa con `MAIL_MAILER=resend` + `RESEND_API_KEY`.

---

## 🛰️ Despliegue

La guía paso a paso para cPanel (hosting actual de **enervia.com.gt**) está en [DEPLOYMENT.md](DEPLOYMENT.md).

---

## 📄 Licencia

Código propietario de Enervisa. Todos los derechos reservados.
