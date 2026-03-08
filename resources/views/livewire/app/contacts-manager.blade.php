<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h2 class="h5 mb-3">Contact Requests</h2>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Name</th><th>Email</th><th>Status</th><th>Message</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @forelse($inquiries as $inquiry)
                    <tr>
                        <td>{{ $inquiry->name }}</td>
                        <td>{{ $inquiry->email }}</td>
                        <td><span class="badge text-bg-light text-dark">{{ $inquiry->status }}</span></td>
                        <td class="text-wrap" style="max-width: 320px;">{{ $inquiry->message }}</td>
                        <td class="text-end d-flex gap-1 justify-content-end">
                            <button class="btn btn-sm btn-outline-warning" wire:click="markInProgress({{ $inquiry->id }})" wire:loading.attr="disabled" wire:target="markInProgress">
                                <span wire:loading.remove wire:target="markInProgress"><i class="bi bi-hourglass-split me-1"></i>In Progress</span>
                                <span wire:loading wire:target="markInProgress"><span class="spinner-border spinner-border-sm me-1"></span>Updating...</span>
                            </button>
                            <button class="btn btn-sm btn-outline-success" wire:click="markResolved({{ $inquiry->id }})" wire:loading.attr="disabled" wire:target="markResolved">
                                <span wire:loading.remove wire:target="markResolved"><i class="bi bi-check2-circle me-1"></i>Resolved</span>
                                <span wire:loading wire:target="markResolved"><span class="spinner-border spinner-border-sm me-1"></span>Updating...</span>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $inquiry->id }})" wire:loading.attr="disabled" wire:target="confirmDelete,deleteConfirmed">
                                <span wire:loading.remove wire:target="confirmDelete,deleteConfirmed"><i class="bi bi-trash me-1"></i>Delete</span>
                                <span wire:loading wire:target="confirmDelete,deleteConfirmed"><span class="spinner-border spinner-border-sm me-1"></span>Deleting...</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary">No inquiries yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
