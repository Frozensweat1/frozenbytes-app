<?php

namespace App\Livewire\Web;

use App\Models\BlogPost;
use App\Models\Page;
use Livewire\Component;

class BlogPage extends Component
{
    public function render()
    {
        return view('livewire.web.blog-page', [
            'page' => Page::query()->where('slug', 'blog')->first(),
            'posts' => BlogPost::query()
                ->where('is_published', true)
                ->orderByDesc('published_at')
                ->latest()
                ->get(),
        ])
            ->layout('layouts.web', ['title' => 'Blog | FrozenBytes']);
    }
}
