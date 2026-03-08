<?php

namespace App\Livewire\Web;

use App\Models\BlogPost;
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
        return view('livewire.web.blog-post-detail-page')
            ->layout('layouts.web', ['title' => $this->post->title.' | Blog']);
    }
}
