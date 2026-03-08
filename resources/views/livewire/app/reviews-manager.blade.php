<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h5 mb-3">{{ $reviewId ? 'Edit Review' : 'New Review' }}</h2>
            <form wire:submit="save" class="d-grid gap-3">                <x-form-errors />
                <input type="text" class="form-control" placeholder="Reviewer Name" wire:model.blur="reviewer_name">
                <input type="text" class="form-control" placeholder="Company (optional)" wire:model.blur="company">
                <input type="number" min="1" max="5" class="form-control" placeholder="Rating (1-5)" wire:model.blur="rating">
                <textarea class="form-control" rows="4" placeholder="Review Text" wire:model.blur="review_text"></textarea>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" wire:model="is_published" id="isPublishedReview">
                    <label class="form-check-label" for="isPublishedReview">Published</label>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire:target="save"><i class="bi bi-floppy me-1"></i>Save</span>
                        <span wire:loading wire:target="save"><span class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" wire:click="resetForm"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                </div>
            </form>
        </div></div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h5 mb-3">Reviews</h2>
            <table class="table align-middle">
                <thead><tr><th>Reviewer</th><th>Rating</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->reviewer_name }}</td>
                        <td>{{ $review->rating }}/5</td>
                        <td><span class="badge {{ $review->is_published ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $review->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $review->id }})" wire:loading.attr="disabled" wire:target="edit"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                            <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $review->id }})" wire:loading.attr="disabled" wire:target="confirmDelete,deleteConfirmed">
                                <span wire:loading.remove wire:target="confirmDelete,deleteConfirmed"><i class="bi bi-trash me-1"></i>Delete</span>
                                <span wire:loading wire:target="confirmDelete,deleteConfirmed"><span class="spinner-border spinner-border-sm me-1"></span>Deleting...</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-secondary">No reviews yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div></div>
    </div>
</div>
