<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">{{ $userId ? 'Edit User' : 'New User' }}</h2>
                <form wire:submit="save" class="d-grid gap-3">
                    <x-form-errors />
                    <input type="text" class="form-control" placeholder="Full Name" wire:model.live="name">
                    <input type="email" class="form-control" placeholder="Email Address" wire:model.live="email">
                    <input type="password" class="form-control" placeholder="{{ $userId ? 'New Password (optional)' : 'Password' }}" wire:model.live="password">
                    <input type="password" class="form-control" placeholder="Confirm Password" wire:model.live="password_confirmation">
                    <select class="form-select" wire:model.live="role">
                        @foreach($roles as $roleName)
                            <option value="{{ $roleName }}">{{ ucfirst($roleName) }}</option>
                        @endforeach
                    </select>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled" wire:target="save">
                            <span wire:loading.remove wire:target="save"><i class="bi bi-floppy me-1"></i>Save User</span>
                            <span wire:loading wire:target="save"><span class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                        </button>
                        <button class="btn btn-outline-secondary" type="button" wire:click="resetForm"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Users</h2>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->roles->first()?->name ?? 'none') }}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $user->id }})" wire:loading.attr="disabled" wire:target="edit"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                                    <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $user->id }})" wire:loading.attr="disabled" wire:target="confirmDelete,deleteConfirmed">
                                        <span wire:loading.remove wire:target="confirmDelete,deleteConfirmed"><i class="bi bi-trash me-1"></i>Delete</span>
                                        <span wire:loading wire:target="confirmDelete,deleteConfirmed"><span class="spinner-border spinner-border-sm me-1"></span>Deleting...</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-secondary">No users found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
