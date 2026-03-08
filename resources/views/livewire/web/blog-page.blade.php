<div>
    <section class="container">
        <x-web.hero :page="$page" :defaultTitle="$page?->title ?? 'Blog'" :defaultSubtitle="$page?->excerpt ?? 'News, insights, and engineering updates.'" />
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if ($post->featured_image_path)
                            <img src="{{ route('media.show', ['path' => $post->featured_image_path], false) }}"
                                class="card-img-top" alt="{{ $post->title }}" style="height: 220px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <span
                                class="badge text-bg-light mb-2">{{ $post->published_at?->format('M d, Y') ?: 'Draft Date' }}</span>
                            <h2 class="h5">{{ $post->title }}</h2>
                            <p class="text-secondary">{{ $post->excerpt }}</p>
                            <p class="small text-secondary mb-0"><code>{{ $post->slug }}</code></p>
                            <a href="{{ route('web.blog.show', ['post' => $post->slug]) }}"
                                class="btn btn-sm btn-outline-primary mt-2">Read More</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No blog posts published yet.</div>
            @endforelse
        </div>
    </section>

</div>
