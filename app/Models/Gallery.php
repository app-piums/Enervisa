<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $fillable = ['title', 'description', 'image_path', 'thumbnail_path', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('active', true)->orderBy('sort_order')->orderByDesc('id');
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::url($this->image_path);
    }

    public function getThumbnailUrlAttribute(): string
    {
        return Storage::url($this->thumbnail_path ?: $this->image_path);
    }
}
