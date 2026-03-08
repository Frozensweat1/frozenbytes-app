<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h5 mb-3">{{ $serviceId ? 'Edit Service' : 'New Service' }}</h2>
            <form wire:submit="save" class="d-grid gap-3">                <x-form-errors />
                <input type="text" class="form-control" placeholder="Title" wire:model.live="title">
                <input type="text" class="form-control" placeholder="Slug" wire:model.live="slug">
                <textarea class="form-control" rows="3" placeholder="Short Description" wire:model.live="description"></textarea>
                <textarea class="form-control" rows="5" placeholder="Full Details" wire:model.live="details"></textarea>
                <input type="number" step="0.01" min="0" class="form-control" placeholder="Price (optional)" wire:model.live="price">
                <input type="file" class="form-control" wire:model="image_file" accept="image/*">
                @if($image_path)
                    <img src="{{ route('media.show', ['path' => $image_path], false) }}" alt="service image" class="img-fluid rounded border" style="max-height: 100px;">
                @endif
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" wire:model="is_published" id="isPublishedService">
                    <label class="form-check-label" for="isPublishedService">Published</label>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="save,image_file">
                        <span wire:loading.remove wire:target="save,image_file"><i class="bi bi-floppy me-1"></i>Save</span>
                        <span wire:loading wire:target="save,image_file"><span class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" wire:click="resetForm"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                </div>
            </form>
        </div></div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h5 mb-3">Services</h2>
            <table class="table align-middle">
                <thead><tr><th>Title</th><th>Image</th><th>Price</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $service->title }}</td>
                        <td>@if($service->image_path)<img src="{{ route('media.show', ['path' => $service->image_path], false) }}" alt="" style="width:52px;height:52px;object-fit:cover;" class="rounded border">@else - @endif</td>
                        <td>{{ $service->price ? '$'.$service->price : '-' }}</td>
                        <td><span class="badge {{ $service->is_published ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $service->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $service->id }})" wire:loading.attr="disabled" wire:target="edit"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                            <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $service->id }})" wire:loading.attr="disabled" wire:target="confirmDelete,deleteConfirmed">
                                <span wire:loading.remove wire:target="confirmDelete,deleteConfirmed"><i class="bi bi-trash me-1"></i>Delete</span>
                                <span wire:loading wire:target="confirmDelete,deleteConfirmed"><span class="spinner-border spinner-border-sm me-1"></span>Deleting...</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary">No services yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div></div>
    </div>
</div>
