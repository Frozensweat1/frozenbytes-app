<?php

namespace App\Livewire\Web;

use App\Models\BlogPost;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Livewire\Component;

class BlogPostDetailPage extends Component
{
    public BlogPost $post;

    public function mount(BlogPost $post): void
    {
        abort_unless($post->is_published, 404);
        $this->post = $post;
    }

    public function render()
    {
        $description = Str::limit(strip_tags($this->post->excerpt ?: $this->post->content), 160);
        $canonicalUrl = route('web.blog.show', ['post' => $this->post->slug]);
        $ogImage = $this->post->featured_image_path
            ? url(route('media.show', ['path' => $this->post->featured_image_path], false))
            : null;
        $siteSetting = SiteSetting::current();

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $this->post->title,
            'description' => $description,
            'datePublished' => optional($this->post->published_at)->toIso8601String(),
            'dateModified' => optional($this->post->updated_at)->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => $siteSetting->business_name,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $siteSetting->business_name,
            ],
            'mainEntityOfPage' => $canonicalUrl,
        ];

        if ($ogImage) {
            $jsonLd['image'] = [$ogImage];
        }

        return view('livewire.web.blog-post-detail-page', [
            'relatedPosts' => BlogPost::query()
                ->where('is_published', true)
                ->where('id', '!=', $this->post->id)
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ])->layout('layouts.web', [
            'title' => $this->post->title.' | Blog',
            'metaDescription' => $description,
            'canonicalUrl' => $canonicalUrl,
            'ogType' => 'article',
            'ogImage' => $ogImage,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ]);
    }
}
