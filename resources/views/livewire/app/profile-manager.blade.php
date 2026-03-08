<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Profile Information</h2>
                <form wire:submit="updateProfile" class="d-grid gap-3">
                    <div>
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" wire:model.live="name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div>
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" wire:model.live="email">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="updateProfile">
                            <span wire:loading.remove wire:target="updateProfile"><i class="bi bi-person-check me-1"></i>Update Profile</span>
                            <span wire:loading wire:target="updateProfile"><span class="spinner-border spinner-border-sm me-1"></span>Updating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Change Password</h2>
                <form wire:submit="updatePassword" class="d-grid gap-3">
                    <div>
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" wire:model.live="current_password">
                        @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div>
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" wire:model.live="password">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div>
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" wire:model.live="password_confirmation">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="updatePassword">
                            <span wire:loading.remove wire:target="updatePassword"><i class="bi bi-shield-lock me-1"></i>Update Password</span>
                            <span wire:loading wire:target="updatePassword"><span class="spinner-border spinner-border-sm me-1"></span>Updating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
