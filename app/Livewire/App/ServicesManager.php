<?php

namespace App\Livewire\App;

use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ServicesManager extends Component
{
    use WithFileUploads;

    public ?int $serviceId = null;
    public string $title = '';
    public string $slug = '';
    public string $description = '';
    public string $details = '';
    public string $price = '';
    public ?string $image_path = null;
    public $image_file;
    public bool $is_published = true;

    public function save(): void
    {
        $data = $this->validate([
            'title' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:140', Rule::unique('services', 'slug')->ignore($this->serviceId)],
            'description' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'is_published' => ['required', 'boolean'],
        ]);

        $data['price'] = ($data['price'] === '' || $data['price'] === null)
            ? null
            : number_format((float) $data['price'], 2, '.', '');

        $service = Service::query()->find($this->serviceId);
        if ($this->image_file) {
            if ($service?->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }

            $data['image_path'] = $this->image_file->store('services', 'public');
        }

        Service::query()->updateOrCreate(['id' => $this->serviceId], $data);
        $this->resetForm();
        $this->resetValidation();
        LivewireAlert::title('Service Saved')
            ->text('Service has been saved.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function edit(int $id): void
    {
        $this->resetValidation();
        $this->reset(['image_file']);

        $service = Service::query()->findOrFail($id);

        $this->serviceId = $service->id;
        $this->title = $service->title;
        $this->slug = $service->slug ?? '';
        $this->description = $service->description ?? '';
        $this->details = $service->details ?? '';
        $this->price = (string) ($service->price ?? '');
        $this->image_path = $service->image_path;
        $this->is_published = $service->is_published;
    }

    public function confirmDelete(int $id): void
    {
        LivewireAlert::title('Delete Service?')
            ->text('This action cannot be undone.')
            ->asConfirm()
            ->onConfirm('deleteConfirmed', ['id' => $id])
            ->show();
    }

    public function deleteConfirmed(array $data): void
    {
        $id = (int) ($data['id'] ?? 0);
        $service = Service::query()->findOrFail($id);
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }
        $service->delete();
        $this->resetForm();
        LivewireAlert::title('Service Deleted')
            ->text('Service has been deleted.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function resetForm(): void
    {
        $this->reset(['serviceId', 'title', 'slug', 'description', 'details', 'price', 'image_path', 'image_file']);
        $this->is_published = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.app.services-manager', [
            'services' => Service::query()->latest()->get(),
        ])
            ->layout('layouts.admin', [
                'title' => 'Manage Services | FrozenBytes',
                'heading' => 'Services Management',
            ]);
    }
}
