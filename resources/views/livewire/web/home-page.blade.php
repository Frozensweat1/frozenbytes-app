<div>
    <section class="container">
        <x-web.hero :page="$homePage" :defaultTitle="'Build, Scale, and Grow with ' . $site->business_name" :defaultSubtitle="$site->tagline ?: 'Reliable digital products for growth-focused companies.'" defaultCtaText="Start Your Project"
            :defaultCtaUrl="route('web.contact')" />

        @if ($homePage?->content)
            <div class="p-4 bg-white rounded-4 shadow-sm mb-4">
                <p class="text-secondary mb-0">{{ $homePage->content }}</p>
            </div>
        @endif

        <h2 class="h4 mb-3">Featured Services</h2>
        <div class="row g-4 mb-4">
            @forelse($services as $service)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if ($service->image_path)
                            <img src="{{ route('media.show', ['path' => $service->image_path], false) }}" alt="{{ $service->title }}" class="card-img-top"
                                style="height: 180px; object-fit: cover;">
                        @else
                            @if($site->logoAssetUrl())
                                <img src="{{ $site->logoAssetUrl() }}" alt="{{ $site->business_name }}" class="card-img-top p-4 bg-light"
                                    style="height: 180px; object-fit: contain;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center text-white fw-semibold"
                                    style="height: 180px; background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
                                    {{ \Illuminate\Support\Str::limit($service->title, 42) }}
                                </div>
                            @endif
                        @endif
                        <div class="card-body">
                            <h3 class="h5">{{ $service->title }}</h3>
                            <p class="text-secondary mb-0">{{ $service->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No services published yet.</div>
            @endforelse
        </div>

        <h2 class="h4 mb-3">Recent Projects</h2>
        <div class="row g-4 mb-4">
            @forelse($projects as $project)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if ($project->cover_image_path)
                            <img src="{{ route('media.show', ['path' => $project->cover_image_path], false) }}" alt="{{ $project->title }}" class="card-img-top"
                                style="height: 180px; object-fit: cover;">
                        @else
                            @if($site->logoAssetUrl())
                                <img src="{{ $site->logoAssetUrl() }}" alt="{{ $site->business_name }}" class="card-img-top p-4 bg-light"
                                    style="height: 180px; object-fit: contain;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center text-white fw-semibold"
                                    style="height: 180px; background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
                                    {{ \Illuminate\Support\Str::limit($project->title, 42) }}
                                </div>
                            @endif
                        @endif
                        <div class="card-body">
                            <h3 class="h5">{{ $project->title }}</h3>
                            <p class="text-secondary mb-0">{{ $project->summary }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No projects published yet.</div>
            @endforelse
        </div>

        <h2 class="h4 mb-3">Featured Blogs</h2>
        <div class="row g-4 mb-4">
            @forelse($blogs as $post)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if ($post->featured_image_path)
                            <img src="{{ route('media.show', ['path' => $post->featured_image_path], false) }}" alt="{{ $post->title }}" class="card-img-top"
                                style="height: 180px; object-fit: cover;">
                        @else
                            @if($site->logoAssetUrl())
                                <img src="{{ $site->logoAssetUrl() }}" alt="{{ $site->business_name }}" class="card-img-top p-4 bg-light"
                                    style="height: 180px; object-fit: contain;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center text-white fw-semibold"
                                    style="height: 180px; background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
                                    {{ \Illuminate\Support\Str::limit($post->title, 42) }}
                                </div>
                            @endif
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h3 class="h5">{{ $post->title }}</h3>
                            <p class="text-secondary">{{ $post->excerpt }}</p>
                            <a href="{{ route('web.blog.show', ['post' => $post->slug]) }}" class="btn btn-outline-primary mt-auto">
                                <i class="bi bi-arrow-right-circle me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No blog posts published yet.</div>
            @endforelse
        </div>

        <h2 class="h4 mb-3">Featured Reviews</h2>
        <div class="row g-4">
            @forelse($reviews as $review)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer_name ?: 'Client') }}&background=0d6efd&color=fff"
                                    alt="{{ $review->reviewer_name }}" class="rounded-circle border" style="width: 56px; height: 56px;">
                                <div>
                                    <h3 class="h6 mb-1">{{ $review->reviewer_name }}</h3>
                                    @if($review->company)
                                        <p class="small text-secondary mb-0">{{ $review->company }}</p>
                                    @endif
                                </div>
                            </div>
                            <p class="text-secondary mb-2">"{{ \Illuminate\Support\Str::limit($review->review_text, 120) }}"</p>
                            <span class="badge text-bg-success mb-3 align-self-start">{{ $review->rating }}/5</span>
                            <a href="{{ route('web.reviews.show', ['review' => $review->id]) }}" class="btn btn-outline-primary mt-auto">
                                <i class="bi bi-arrow-right-circle me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No reviews published yet.</div>
            @endforelse
        </div>
    </section>

</div>
