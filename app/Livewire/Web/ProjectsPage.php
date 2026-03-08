<?php

namespace App\Livewire\Web;

use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use Livewire\Component;

class ProjectsPage extends Component
{
    public array $selectedServices = [];

    public function render()
    {
        $projectsQuery = Project::query()
            ->where('is_published', true)
            ->with('services')
            ->latest();

        if (!empty($this->selectedServices)) {
            $projectsQuery->whereHas('services', function ($query): void {
                $query->whereIn('services.id', $this->selectedServices);
            });
        }

        return view('livewire.web.projects-page', [
            'page' => Page::query()->where('slug', 'projects')->first(),
            'services' => Service::query()->where('is_published', true)->orderBy('title')->get(),
            'projects' => $projectsQuery->get(),
        ])
            ->layout('layouts.web', ['title' => 'Projects | FrozenBytes']);
    }
}
