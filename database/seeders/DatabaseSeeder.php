<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@enervisa.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('enervisa2026'),
                'role' => 'admin',
            ]
        );

        $settings = [
            ['key' => 'hero_title', 'value' => 'Enervisa', 'group' => 'hero', 'type' => 'text', 'label' => 'Título del Hero'],
            ['key' => 'hero_subtitle', 'value' => 'Eficiencia que construye el futuro energético', 'group' => 'hero', 'type' => 'text', 'label' => 'Subtítulo del Hero'],
            ['key' => 'hero_description', 'value' => 'Soluciones integrales en generación, transmisión y distribución de energía eléctrica con los más altos estándares de calidad y eficiencia.', 'group' => 'hero', 'type' => 'textarea', 'label' => 'Descripción del Hero'],
            ['key' => 'about_title', 'value' => '¿Quiénes Somos?', 'group' => 'about', 'type' => 'text', 'label' => 'Título Nosotros'],
            ['key' => 'about_text', 'value' => 'Enervisa es una empresa especializada en el sector energético, dedicada a diseñar, construir y mantener infraestructura eléctrica de clase mundial. Combinamos experiencia técnica, tecnología de vanguardia y un compromiso firme con la sostenibilidad para impulsar el desarrollo de comunidades e industrias.', 'group' => 'about', 'type' => 'textarea', 'label' => 'Texto Nosotros'],
            ['key' => 'stat_projects', 'value' => '120+', 'group' => 'about', 'type' => 'text', 'label' => 'Stat Proyectos'],
            ['key' => 'stat_clients', 'value' => '80+', 'group' => 'about', 'type' => 'text', 'label' => 'Stat Clientes'],
            ['key' => 'stat_years', 'value' => '15', 'group' => 'about', 'type' => 'text', 'label' => 'Stat Años'],
            ['key' => 'stat_team', 'value' => '200+', 'group' => 'about', 'type' => 'text', 'label' => 'Stat Equipo'],
            ['key' => 'contact_email', 'value' => 'contacto@enervisa.com', 'group' => 'contact', 'type' => 'email', 'label' => 'Correo'],
            ['key' => 'contact_phone', 'value' => '+58 (212) 000-0000', 'group' => 'contact', 'type' => 'text', 'label' => 'Teléfono'],
            ['key' => 'contact_whatsapp', 'value' => '+58 414 000 0000', 'group' => 'contact', 'type' => 'text', 'label' => 'WhatsApp'],
            ['key' => 'contact_address', 'value' => 'Av. Principal, Caracas, Venezuela', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Dirección'],
            ['key' => 'contact_hours', 'value' => 'Lun – Vie: 8:00 AM – 6:00 PM', 'group' => 'contact', 'type' => 'text', 'label' => 'Horario'],
            ['key' => 'maps_embed_url', 'value' => env('GOOGLE_MAPS_EMBED_URL', ''), 'group' => 'contact', 'type' => 'url', 'label' => 'URL Embed Google Maps'],
            ['key' => 'social_facebook', 'value' => '#', 'group' => 'social', 'type' => 'url', 'label' => 'Facebook'],
            ['key' => 'social_instagram', 'value' => '#', 'group' => 'social', 'type' => 'url', 'label' => 'Instagram'],
            ['key' => 'social_linkedin', 'value' => '#', 'group' => 'social', 'type' => 'url', 'label' => 'LinkedIn'],
            ['key' => 'seo_description', 'value' => 'Enervisa — Empresa líder en generación, transmisión y distribución de energía eléctrica.', 'group' => 'seo', 'type' => 'textarea', 'label' => 'Meta Description'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }

        $this->call([
            ServiceSeeder::class,
            GallerySeeder::class,
        ]);
    }
}
