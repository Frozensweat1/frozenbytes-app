<?php

namespace App\Livewire\App;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class PagesManager extends Component
{
    public ?int $pageId = null;
    public string $title = '';
    public string $slug = '';
    public string $excerpt = '';
    public string $content = '';
    public string $hero_title = '';
    public string $hero_subtitle = '';
    public string $hero_cta_text = '';
    public string $hero_cta_url = '';
    public bool $is_published = true;
    public int $sort_order = 0;

    public function save(): void
    {
        $data = $this->validate([
            'title' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:120', Rule::unique('pages', 'slug')->ignore($this->pageId)],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'hero_title' => ['nullable', 'string', 'max:160'],
            'hero_subtitle' => ['nullable', 'string', 'max:255'],
            'hero_cta_text' => ['nullable', 'string', 'max:80'],
            'hero_cta_url' => ['nullable', 'url', 'max:255'],
            'is_published' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        Page::query()->updateOrCreate(['id' => $this->pageId], $data);
        $this->resetForm();

        LivewireAlert::title('Page Saved')
            ->text('Page has been saved.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function edit(int $id): void
    {
        $page = Page::query()->findOrFail($id);

        $this->pageId = $page->id;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->excerpt = $page->excerpt ?? '';
        $this->content = $page->content ?? '';
        $this->hero_title = $page->hero_title ?? '';
        $this->hero_subtitle = $page->hero_subtitle ?? '';
        $this->hero_cta_text = $page->hero_cta_text ?? '';
        $this->hero_cta_url = $page->hero_cta_url ?? '';
        $this->is_published = $page->is_published;
        $this->sort_order = $page->sort_order;
    }

    public function confirmDelete(int $id): void
    {
        LivewireAlert::title('Delete Page?')
            ->text('This action cannot be undone.')
            ->asConfirm()
            ->onConfirm('deleteConfirmed', ['id' => $id])
            ->show();
    }

    public function deleteConfirmed(array $data): void
    {
        $id = (int) ($data['id'] ?? 0);
        Page::query()->findOrFail($id)->delete();
        $this->resetForm();
        LivewireAlert::title('Page Deleted')
            ->text('Page has been deleted.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function resetForm(): void
    {
        $this->reset(['pageId', 'title', 'slug', 'excerpt', 'content', 'hero_title', 'hero_subtitle', 'hero_cta_text', 'hero_cta_url']);
        $this->is_published = true;
        $this->sort_order = 0;
    }

    public function render()
    {
        return view('livewire.app.pages-manager', [
            'pages' => Page::query()->orderBy('sort_order')->orderBy('title')->get(),
        ])->layout('layouts.admin', [
            'title' => 'Manage Pages | FrozenBytes',
            'heading' => 'Page Management',
        ]);
    }
}
