<?php

namespace App\Livewire\Web;

use App\Models\Project;
use Livewire\Component;

class ProjectDetailPage extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        abort_unless($project->is_published, 404);
        $this->project = $project->load('images', 'services');
    }

    public function render()
    {
        return view('livewire.web.project-detail-page')
            ->layout('layouts.web', ['title' => $this->project->title.' | Projects']);
    }
}
