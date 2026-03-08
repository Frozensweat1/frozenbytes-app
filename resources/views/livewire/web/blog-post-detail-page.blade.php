<div>
    <section class="container">
        <article class="card border-0 shadow-sm overflow-hidden">
            @if ($post->featured_image_path)
                <img src="{{ route('media.show', ['path' => $post->featured_image_path], false) }}"
                    alt="{{ $post->title }}" style="width:100%;max-height:380px;object-fit:cover;">
            @endif
            <div class="card-body p-4 p-md-5">
                <a href="{{ route('web.blog') }}" class="small text-decoration-none">&larr; Back to Blog</a>
                <h1 class="h2 mt-2">{{ $post->title }}</h1>
                <p class="small text-secondary mb-3">{{ $post->published_at?->format('M d, Y') }}</p>
                <p class="text-secondary">{{ $post->excerpt }}</p>
                <div class="text-secondary">{!! nl2br(e($post->content)) !!}</div>
            </div>
        </article>
    </section>

</div>
