<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'business_name',
        'logo_url',
        'logo_path',
        'background_one_path',
        'background_two_path',
        'tagline',
        'support_email',
        'support_phone',
        'address',
        'google_map_url',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'tiktok_url',
        'gmail_url',
        'footer_text',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'business_name' => 'FrozenBytes',
            'footer_text' => 'All rights reserved.',
        ]);
    }

    public function logoAssetUrl(): ?string
    {
        if ($this->logo_path) {
            return route('media.show', ['path' => $this->logo_path], false);
        }

        return $this->logo_url;
    }

    public function backgroundOneAssetUrl(): ?string
    {
        return $this->background_one_path
            ? route('media.show', ['path' => $this->background_one_path], false)
            : null;
    }

    public function backgroundTwoAssetUrl(): ?string
    {
        return $this->background_two_path
            ? route('media.show', ['path' => $this->background_two_path], false)
            : null;
    }
}
