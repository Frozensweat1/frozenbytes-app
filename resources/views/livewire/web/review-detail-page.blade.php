<div>
    <section class="container">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->reviewer_name ?: 'Client') }}&background=0d6efd&color=fff"
                        alt="{{ $review->reviewer_name }}" class="rounded-circle border" style="width: 72px; height: 72px;">
                    <div>
                        <h1 class="h4 mb-1">{{ $review->reviewer_name }}</h1>
                        @if($review->company)
                            <p class="text-secondary mb-1">{{ $review->company }}</p>
                        @endif
                        <span class="badge text-bg-success">{{ $review->rating }}/5</span>
                    </div>
                </div>

                <p class="mb-0 text-secondary fs-5">"{{ $review->review_text }}"</p>

                <a href="{{ route('web.reviews') }}" class="btn btn-outline-primary mt-4">
                    <i class="bi bi-arrow-left me-1"></i>Back to Reviews
                </a>
            </div>
        </div>
    </section>
</div>
