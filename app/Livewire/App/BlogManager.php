<?php

namespace App\Livewire\App;

use App\Models\BlogPost;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class BlogManager extends Component
{
    use WithFileUploads;

    public ?int $postId = null;
    public string $title = '';
    public string $slug = '';
    public string $excerpt = '';
    public string $content = '';
    public ?string $featured_image_path = null;
    public $featured_image_file;
    public string $published_at = '';
    public bool $is_published = false;

    public function save(): void
    {
        $data = $this->validate([
            'title' => ['required', 'string', 'max:140'],
            'slug' => ['required', 'string', 'max:140', Rule::unique('blog_posts', 'slug')->ignore($this->postId)],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'featured_image_file' => ['nullable', 'image', 'max:4096'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['required', 'boolean'],
        ]);

        if ($data['published_at'] === '') {
            $data['published_at'] = null;
        }

        $post = BlogPost::query()->find($this->postId);
        if ($this->featured_image_file) {
            if ($post?->featured_image_path) {
                Storage::disk('public')->delete($post->featured_image_path);
            }

            $data['featured_image_path'] = $this->featured_image_file->store('blog', 'public');
        }

        BlogPost::query()->updateOrCreate(['id' => $this->postId], $data);
        $this->resetForm();
        $this->resetValidation();
        LivewireAlert::title('Blog Post Saved')
            ->text('Blog post has been saved.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function edit(int $id): void
    {
        $this->resetValidation();
        $this->reset(['featured_image_file']);

        $post = BlogPost::query()->findOrFail($id);

        $this->postId = $post->id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->excerpt = $post->excerpt ?? '';
        $this->content = $post->content ?? '';
        $this->featured_image_path = $post->featured_image_path;
        $this->published_at = $post->published_at ? Carbon::parse($post->published_at)->format('Y-m-d\TH:i') : '';
        $this->is_published = $post->is_published;
    }

    public function confirmDelete(int $id): void
    {
        LivewireAlert::title('Delete Blog Post?')
            ->text('This action cannot be undone.')
            ->asConfirm()
            ->onConfirm('deleteConfirmed', ['id' => $id])
            ->show();
    }

    public function deleteConfirmed(array $data): void
    {
        $id = (int) ($data['id'] ?? 0);
        $post = BlogPost::query()->findOrFail($id);
        if ($post->featured_image_path) {
            Storage::disk('public')->delete($post->featured_image_path);
        }
        $post->delete();
        $this->resetForm();
        LivewireAlert::title('Blog Post Deleted')
            ->text('Blog post has been deleted.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function resetForm(): void
    {
        $this->reset(['postId', 'title', 'slug', 'excerpt', 'content', 'featured_image_path', 'featured_image_file', 'published_at']);
        $this->is_published = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.app.blog-manager', [
            'posts' => BlogPost::query()->latest()->get(),
        ])
            ->layout('layouts.admin', [
                'title' => 'Manage Blog | FrozenBytes',
                'heading' => 'Blog Management',
            ]);
    }
}
