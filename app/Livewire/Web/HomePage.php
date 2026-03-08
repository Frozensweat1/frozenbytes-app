<?php

namespace App\Livewire\Web;

use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        return view('livewire.web.home-page', [
            'homePage' => Page::query()->where('slug', 'home')->first(),
            'services' => Service::query()->where('is_published', true)->latest()->limit(3)->get(),
            'projects' => Project::query()->where('is_published', true)->latest()->limit(3)->get(),
            'site' => SiteSetting::current(),
        ])
            ->layout('layouts.web', ['title' => 'Home | FrozenBytes']);
    }
}
