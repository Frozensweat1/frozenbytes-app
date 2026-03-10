<?php

namespace App\Livewire\Web;

use App\Models\BlogPost;
use App\Models\Page;
use Illuminate\Support\Str;
use Livewire\Component;

class BlogPage extends Component
{
    public function render()
    {
        $page = Page::query()->where('slug', 'blog')->first();
        $metaDescription = $page?->excerpt
            ? Str::limit(strip_tags($page->excerpt), 160)
            : 'Read FrozenBytes insights on web engineering, product delivery, and digital growth.';

        return view('livewire.web.blog-page', [
            'page' => $page,
            'posts' => BlogPost::query()
                ->where('is_published', true)
                ->orderByDesc('published_at')
                ->latest()
                ->get(),
        ])
            ->layout('layouts.web', [
                'title' => 'Blog | FrozenBytes',
                'metaDescription' => $metaDescription,
                'canonicalUrl' => route('web.blog'),
            ]);
    }
}
