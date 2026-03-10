<div>
    <section class="container">
        <x-web.hero :page="$page" :defaultTitle="$page?->title ?? 'Reviews and Ratings'" :defaultSubtitle="$page?->excerpt ?? 'Client trust and delivery quality feedback.'" />

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h2 class="h5 mb-3">Leave a Review</h2>
                @if (session('review_submitted'))
                    <div class="alert alert-success">{{ session('review_submitted') }}</div>
                @endif

                <form wire:submit="submitReview" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Your Name</label>
                        <input type="text" class="form-control" wire:model.blur="reviewer_name" placeholder="Jane Doe">
                        @error('reviewer_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company (Optional)</label>
                        <input type="text" class="form-control" wire:model.blur="company" placeholder="FrozenBytes Client">
                        @error('company') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Rating</label>
                        <input type="number" min="1" max="5" class="form-control" wire:model.blur="rating" placeholder="5">
                        @error('rating') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Review</label>
                        <textarea class="form-control" rows="4" wire:model.blur="review_text" placeholder="Tell us about your experience."></textarea>
                        @error('review_text') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <small class="text-secondary">Submitted reviews are moderated before they are published.</small>
                        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="submitReview">
                            <span wire:loading.remove wire:target="submitReview"><i class="bi bi-send me-1"></i>Submit Review</span>
                            <span wire:loading wire:target="submitReview"><span class="spinner-border spinner-border-sm me-1"></span>Submitting...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @forelse($reviews as $review)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer_name ?: 'Client') }}&background=0d6efd&color=fff"
                                    alt="{{ $review->reviewer_name }}" class="rounded-circle border" style="width: 56px; height: 56px;">
                                <div>
                                    <h2 class="h5 mb-0">{{ $review->reviewer_name }}</h2>
                                    @if($review->company)
                                        <p class="small text-secondary mb-0">{{ $review->company }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="badge text-bg-success mb-2">{{ $review->rating }}/5</span>
                            <p class="text-secondary">{{ $review->review_text }}</p>
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
