<?php

namespace App\Livewire\Web;

use App\Models\Service;
use Livewire\Component;

class ServiceDetailPage extends Component
{
    public Service $service;

    public function mount(Service $service): void
    {
        abort_unless($service->is_published, 404);
        $this->service = $service->load(['projects' => function ($query) {
            $query->where('is_published', true)->latest();
        }]);
    }

    public function render()
    {
        return view('livewire.web.service-detail-page')
            ->layout('layouts.web', ['title' => $this->service->title.' | Services']);
    }
}
