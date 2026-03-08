<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h5 mb-3">{{ $postId ? 'Edit Blog Post' : 'New Blog Post' }}</h2>
            <form wire:submit="save" class="d-grid gap-3">                <x-form-errors />
                <input type="text" class="form-control" placeholder="Title" wire:model.live="title">
                <input type="text" class="form-control" placeholder="Slug" wire:model.live="slug">
                <input type="text" class="form-control" placeholder="Excerpt" wire:model.live="excerpt">
                <textarea class="form-control" rows="5" placeholder="Content" wire:model.live="content"></textarea>
                <input type="datetime-local" class="form-control" wire:model.live="published_at">
                <input type="file" class="form-control" wire:model="featured_image_file" accept="image/*">
                @if($featured_image_path)
                    <img src="{{ route('media.show', ['path' => $featured_image_path], false) }}" alt="blog image" class="img-fluid rounded border" style="max-height: 100px;">
                @endif
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" wire:model="is_published" id="isPublishedBlog">
                    <label class="form-check-label" for="isPublishedBlog">Published</label>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="save,featured_image_file">
                        <span wire:loading.remove wire:target="save,featured_image_file"><i class="bi bi-floppy me-1"></i>Save</span>
                        <span wire:loading wire:target="save,featured_image_file"><span class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" wire:click="resetForm"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                </div>
            </form>
        </div></div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h5 mb-3">Blog Posts</h2>
            <table class="table align-middle">
                <thead><tr><th>Title</th><th>Image</th><th>Published At</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>@if($post->featured_image_path)<img src="{{ route('media.show', ['path' => $post->featured_image_path], false) }}" alt="" style="width:52px;height:52px;object-fit:cover;" class="rounded border">@else - @endif</td>
                        <td>{{ $post->published_at?->format('Y-m-d H:i') ?: '-' }}</td>
                        <td><span class="badge {{ $post->is_published ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $post->id }})" wire:loading.attr="disabled" wire:target="edit"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                            <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $post->id }})" wire:loading.attr="disabled" wire:target="confirmDelete,deleteConfirmed">
                                <span wire:loading.remove wire:target="confirmDelete,deleteConfirmed"><i class="bi bi-trash me-1"></i>Delete</span>
                                <span wire:loading wire:target="confirmDelete,deleteConfirmed"><span class="spinner-border spinner-border-sm me-1"></span>Deleting...</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary">No blog posts yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div></div>
    </div>
</div>
