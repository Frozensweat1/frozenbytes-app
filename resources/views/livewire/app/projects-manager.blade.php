<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h5 mb-3">{{ $projectId ? 'Edit Project' : 'New Project' }}</h2>
            <form wire:submit="save" class="d-grid gap-3">
                <x-form-errors />
                <input type="text" class="form-control" placeholder="Title" wire:model.live="title">
                <input type="text" class="form-control" placeholder="Slug" wire:model.live="slug">
                <input type="text" class="form-control" placeholder="Client Name" wire:model.live="client_name">
                <textarea class="form-control" rows="3" placeholder="Summary" wire:model.live="summary"></textarea>
                <textarea class="form-control" rows="5" placeholder="Full Details" wire:model.live="details"></textarea>
                <input type="url" class="form-control" placeholder="Project URL" wire:model.live="project_url">
                <label class="form-label mb-0">Linked Services</label>
                <select class="form-select" wire:model.live="service_ids" multiple size="4">
                    @foreach($services as $serviceOption)
                        <option value="{{ $serviceOption->id }}">{{ $serviceOption->title }}</option>
                    @endforeach
                </select>
                <label class="form-label mb-0">Cover Image</label>
                <input type="file" class="form-control" wire:model="cover_image_file" accept="image/*">
                @if($cover_image_path)
                    <img src="{{ route('media.show', ['path' => $cover_image_path], false) }}" alt="cover image" class="img-fluid rounded border" style="max-height: 100px;">
                @endif
                <label class="form-label mb-0">Gallery Images (max 4)</label>
                <input type="file" class="form-control" wire:model="gallery_files" accept="image/*" multiple>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" wire:model="is_published" id="isPublishedProject">
                    <label class="form-check-label" for="isPublishedProject">Published</label>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="save,cover_image_file,gallery_files">
                        <span wire:loading.remove wire:target="save,cover_image_file,gallery_files"><i class="bi bi-floppy me-1"></i>Save</span>
                        <span wire:loading wire:target="save,cover_image_file,gallery_files"><span class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" wire:click="resetForm"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                </div>
            </form>
        </div></div>
    </div>
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm"><div class="card-body">
            <h2 class="h5 mb-3">Projects</h2>
            <table class="table align-middle">
                <thead><tr><th>Title</th><th>Services</th><th>Cover</th><th>Gallery</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>
                            @forelse($project->services as $serviceBadge)
                                <span class="badge text-bg-light border">{{ $serviceBadge->title }}</span>
                            @empty
                                <span class="text-secondary">-</span>
                            @endforelse
                        </td>
                        <td>@if($project->cover_image_path)<img src="{{ route('media.show', ['path' => $project->cover_image_path], false) }}" alt="" style="width:52px;height:52px;object-fit:cover;" class="rounded border">@else - @endif</td>
                        <td>{{ $project->images_count }}</td>
                        <td><span class="badge {{ $project->is_published ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $project->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $project->id }})" wire:loading.attr="disabled" wire:target="edit"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                            <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $project->id }})" wire:loading.attr="disabled" wire:target="confirmDelete,deleteConfirmed">
                                <span wire:loading.remove wire:target="confirmDelete,deleteConfirmed"><i class="bi bi-trash me-1"></i>Delete</span>
                                <span wire:loading wire:target="confirmDelete,deleteConfirmed"><span class="spinner-border spinner-border-sm me-1"></span>Deleting...</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-secondary">No projects yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div></div>
    </div>
</div>
