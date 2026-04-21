<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('active', true)->orderBy('sort_order');
    }
}
