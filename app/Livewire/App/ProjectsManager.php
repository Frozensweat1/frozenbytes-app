<?php

namespace App\Livewire\App;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProjectsManager extends Component
{
    use WithFileUploads;

    public ?int $projectId = null;
    public string $title = '';
    public string $slug = '';
    public string $client_name = '';
    public string $summary = '';
    public string $details = '';
    public ?string $cover_image_path = null;
    public $cover_image_file;
    public array $gallery_files = [];
    public array $service_ids = [];
    public string $project_url = '';
    public bool $is_published = true;

    public function save(): void
    {
        $data = $this->validate([
            'title' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:140', Rule::unique('projects', 'slug')->ignore($this->projectId)],
            'client_name' => ['nullable', 'string', 'max:120'],
            'summary' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
            'cover_image_file' => ['nullable', 'image', 'max:4096'],
            'gallery_files' => ['nullable', 'array', 'max:4'],
            'gallery_files.*' => ['image', 'max:4096'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['integer', 'exists:services,id'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'is_published' => ['required', 'boolean'],
        ]);

        if (count($this->gallery_files) > 4) {
            $this->addError('gallery_files', 'A maximum of 4 gallery images is allowed.');

            return;
        }

        $project = Project::query()->find($this->projectId);
        if ($this->cover_image_file) {
            if ($project?->cover_image_path) {
                Storage::disk('public')->delete($project->cover_image_path);
            }

            $data['cover_image_path'] = $this->cover_image_file->store('projects/cover', 'public');
        }

        $project = Project::query()->updateOrCreate(['id' => $this->projectId], $data);
        $project->services()->sync($this->service_ids);

        if (!empty($this->gallery_files)) {
            foreach ($project->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            $project->images()->delete();

            foreach ($this->gallery_files as $index => $file) {
                $project->images()->create([
                    'image_path' => $file->store('projects/gallery', 'public'),
                    'sort_order' => $index + 1,
                ]);
            }
        }

        $this->resetForm();
        $this->resetValidation();
        LivewireAlert::title('Project Saved')
            ->text('Project has been saved.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function edit(int $id): void
    {
        $this->resetValidation();
        $this->reset(['cover_image_file', 'gallery_files']);

        $project = Project::query()->with('services')->findOrFail($id);

        $this->projectId = $project->id;
        $this->title = $project->title;
        $this->slug = $project->slug ?? '';
        $this->client_name = $project->client_name ?? '';
        $this->summary = $project->summary ?? '';
        $this->details = $project->details ?? '';
        $this->cover_image_path = $project->cover_image_path;
        $this->service_ids = $project->services->pluck('id')->map(fn ($id) => (int) $id)->all();
        $this->project_url = $project->project_url ?? '';
        $this->is_published = $project->is_published;
    }

    public function confirmDelete(int $id): void
    {
        LivewireAlert::title('Delete Project?')
            ->text('This action cannot be undone.')
            ->asConfirm()
            ->onConfirm('deleteConfirmed', ['id' => $id])
            ->show();
    }

    public function deleteConfirmed(array $data): void
    {
        $id = (int) ($data['id'] ?? 0);
        $project = Project::query()->with('images')->findOrFail($id);
        if ($project->cover_image_path) {
            Storage::disk('public')->delete($project->cover_image_path);
        }
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $project->delete();
        $this->resetForm();
        LivewireAlert::title('Project Deleted')
            ->text('Project has been deleted.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function resetForm(): void
    {
        $this->reset(['projectId', 'title', 'slug', 'client_name', 'summary', 'details', 'project_url', 'cover_image_path', 'cover_image_file', 'gallery_files', 'service_ids']);
        $this->is_published = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.app.projects-manager', [
            'projects' => Project::query()->withCount('images')->with('services')->latest()->get(),
            'services' => Service::query()->orderBy('title')->get(),
        ])
            ->layout('layouts.admin', [
                'title' => 'Manage Projects | FrozenBytes',
                'heading' => 'Projects Management',
            ]);
    }
}
