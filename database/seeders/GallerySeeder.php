<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Services\ImageProcessor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $sourceDir = base_path('../Imagenes');
        if (!File::isDirectory($sourceDir)) {
            $this->command->warn("Source image directory not found: {$sourceDir}");
            return;
        }

        $sourceFiles = collect(File::files($sourceDir))
            ->filter(fn ($f) => in_array(strtolower($f->getExtension()), ['jpg', 'jpeg', 'png', 'webp']))
            ->sortBy(fn ($f) => $f->getFilename())
            ->values();

        $projects = [
            ['title' => 'Instalación de Subestación',           'description' => 'Montaje de torres de media tensión con aisladores y muro perimetral en subestación.'],
            ['title' => 'Montaje de Equipos de Transformación', 'description' => 'Estructura de postes con transformadores y switchgear instalados en sitio de obra.'],
            ['title' => 'Tendido de Líneas de Transmisión',     'description' => 'Líneas de transmisión sobre terreno rural con postes y muro perimetral.'],
            ['title' => 'Proyecto Solar Fotovoltaico',          'description' => 'Paneles solares instalados dentro del perímetro del proyecto energético.'],
            ['title' => 'Preparación de Sitio',                 'description' => 'Vista panorámica del terreno con postes de alta tensión y acceso al proyecto.'],
            ['title' => 'Instalación de Postes en Vía',         'description' => 'Equipo de perforación e instalación de postes con cuadrilla especializada.'],
        ];

        Storage::disk('public')->makeDirectory('gallery');
        Storage::disk('public')->makeDirectory('gallery/thumbs');

        $processor = app(ImageProcessor::class);

        foreach ($sourceFiles as $i => $file) {
            $project = $projects[$i] ?? ['title' => 'Proyecto Enervisa', 'description' => 'Proyecto energético realizado por Enervisa.'];
            $filename = 'proyecto-' . str_pad($i + 1, 2, '0', STR_PAD_LEFT) . '.jpg';
            $targetPath = 'gallery/' . $filename;

            // Copy original + generate thumbnail
            Storage::disk('public')->put($targetPath, File::get($file->getRealPath()));
            $thumbPath = $processor->generateThumbnail($targetPath);

            Gallery::updateOrCreate(
                ['image_path' => $targetPath],
                [
                    'title'          => $project['title'],
                    'description'    => $project['description'],
                    'thumbnail_path' => $thumbPath,
                    'sort_order'     => $i + 1,
                    'active'         => true,
                ]
            );
        }

        $this->command->info('Gallery seeded: ' . $sourceFiles->count() . ' images.');
    }
}
