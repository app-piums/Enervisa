<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Generación de Energía',
                'description' => 'Diseño, construcción y operación de plantas de generación eléctrica: térmicas, solares fotovoltaicas e híbridas adaptadas a cada necesidad.',
                'icon' => 'bolt',
                'sort_order' => 1,
            ],
            [
                'title' => 'Transmisión y Distribución',
                'description' => 'Tendido de líneas de alta, media y baja tensión, instalación de subestaciones y redes de distribución con ingeniería de precisión.',
                'icon' => 'tower',
                'sort_order' => 2,
            ],
            [
                'title' => 'Subestaciones Eléctricas',
                'description' => 'Montaje, automatización y mantenimiento de subestaciones con equipos de switchgear, transformadores y protecciones modernas.',
                'icon' => 'cube',
                'sort_order' => 3,
            ],
            [
                'title' => 'Energía Solar Fotovoltaica',
                'description' => 'Proyectos llave en mano de parques solares y autoconsumo industrial para impulsar tu transición energética sostenible.',
                'icon' => 'sun',
                'sort_order' => 4,
            ],
            [
                'title' => 'Mantenimiento Predictivo',
                'description' => 'Diagnóstico, termografía, análisis de aceite y mantenimiento preventivo de equipos eléctricos para maximizar la disponibilidad.',
                'icon' => 'wrench',
                'sort_order' => 5,
            ],
            [
                'title' => 'Consultoría e Ingeniería',
                'description' => 'Estudios de carga, factibilidad, diseño eléctrico y asesoría normativa para proyectos industriales y comerciales.',
                'icon' => 'chart',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(['title' => $s['title']], $s + ['active' => true]);
        }
    }
}
