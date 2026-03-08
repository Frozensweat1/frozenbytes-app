<div>
    <section class="container">
        <x-web.hero :page="$page" :defaultTitle="$page?->title ?? 'Reviews and Ratings'" :defaultSubtitle="$page?->excerpt ?? 'Client trust and delivery quality feedback.'" />
        <div class="row g-4">
            @forelse($reviews as $review)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <span class="badge text-bg-success mb-2">{{ $review->rating }}/5</span>
                            <h2 class="h5">{{ $review->reviewer_name }}</h2>
                            <p class="small text-secondary">{{ $review->company }}</p>
                            <p class="text-secondary mb-0">{{ $review->review_text }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No reviews published yet.</div>
            @endforelse
        </div>
    </section>

</div>
