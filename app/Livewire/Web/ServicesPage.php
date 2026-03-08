<?php

namespace App\Livewire\Web;

use App\Models\Page;
use App\Models\Service;
use Livewire\Component;

class ServicesPage extends Component
{
    public function render()
    {
        return view('livewire.web.services-page', [
            'page' => Page::query()->where('slug', 'services')->first(),
            'services' => Service::query()
                ->where('is_published', true)
                ->with(['projects' => function ($query) {
                    $query->where('is_published', true)->latest();
                }])
                ->latest()
                ->get(),
        ])
            ->layout('layouts.web', ['title' => 'Services | FrozenBytes']);
    }
}
