<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'client_name',
        'summary',
        'details',
        'cover_image_path',
        'project_url',
        'is_published',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getRouteKey(): mixed
    {
        return $this->slug ?: $this->getKey();
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where($field ?? $this->getRouteKeyName(), $value)
            ->orWhere('id', $value)
            ->firstOrFail();
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withTimestamps();
    }

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }
}
