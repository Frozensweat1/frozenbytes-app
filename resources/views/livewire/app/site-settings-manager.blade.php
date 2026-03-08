<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h2 class="h5 mb-3">Business Settings</h2>
        <form wire:submit="save" class="row g-3">
            <div class="col-12"><x-form-errors /></div>
            <div class="col-md-6">
                <label class="form-label">Business Name</label>
                <input type="text" class="form-control" wire:model.blur="business_name">
            </div>
            <div class="col-md-6">
                <label class="form-label">Logo URL (optional)</label>
                <input type="url" class="form-control" wire:model.blur="logo_url">
            </div>
            <div class="col-md-4">
                <label class="form-label">Logo File</label>
                <input type="file" class="form-control" wire:model="logo_file" accept="image/*">
            </div>
            <div class="col-md-4">
                <label class="form-label">Background 1</label>
                <input type="file" class="form-control" wire:model="background_one_file" accept="image/*">
            </div>
            <div class="col-md-4">
                <label class="form-label">Background 2</label>
                <input type="file" class="form-control" wire:model="background_two_file" accept="image/*">
            </div>
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-md-4">
                        <small class="text-muted d-block mb-1">Current Logo</small>
                        @if ($logo_path)
                            <img src="{{ route('media.show', ['path' => $logo_path], false) }}" alt="logo"
                                class="img-fluid rounded border" style="max-height: 80px;">
                        @elseif($logo_url)
                            <img src="{{ $logo_url }}" alt="logo" class="img-fluid rounded border"
                                style="max-height: 80px;">
                        @else
                            <span class="text-secondary small">No logo uploaded.</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block mb-1">Current Background 1</small>
                        @if ($background_one_path)
                            <img src="{{ route('media.show', ['path' => $background_one_path], false) }}" alt="bg1"
                                class="img-fluid rounded border" style="max-height: 80px;">
                        @else
                            <span class="text-secondary small">Not set.</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block mb-1">Current Background 2</small>
                        @if ($background_two_path)
                            <img src="{{ route('media.show', ['path' => $background_two_path], false) }}" alt="bg2"
                                class="img-fluid rounded border" style="max-height: 80px;">
                        @else
                            <span class="text-secondary small">Not set.</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tagline</label>
                <input type="text" class="form-control" wire:model.blur="tagline">
            </div>
            <div class="col-md-6">
                <label class="form-label">Footer Text</label>
                <input type="text" class="form-control" wire:model.blur="footer_text">
            </div>
            <div class="col-md-6">
                <label class="form-label">Support Email</label>
                <input type="email" class="form-control" wire:model.blur="support_email">
            </div>
            <div class="col-md-6">
                <label class="form-label">Support Phone</label>
                <input type="text" class="form-control" wire:model.blur="support_phone">
            </div>
            <div class="col-12">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" wire:model.blur="address">
            </div>
            <div class="col-12">
                <label class="form-label">Google Map Embed URL</label>
                <input type="url" class="form-control" wire:model.blur="google_map_url"
                    placeholder="https://www.google.com/maps/embed?...">
            </div>
            <div class="col-md-4">
                <label class="form-label">Facebook URL</label>
                <input type="url" class="form-control" wire:model.blur="facebook_url">
            </div>
            <div class="col-md-4">
                <label class="form-label">Instagram URL</label>
                <input type="url" class="form-control" wire:model.blur="instagram_url">
            </div>
            <div class="col-md-4">
                <label class="form-label">LinkedIn URL</label>
                <input type="url" class="form-control" wire:model.blur="linkedin_url">
            </div>
            <div class="col-md-4">
                <label class="form-label">YouTube URL</label>
                <input type="url" class="form-control" wire:model.blur="youtube_url">
            </div>
            <div class="col-md-4">
                <label class="form-label">TikTok URL</label>
                <input type="url" class="form-control" wire:model.blur="tiktok_url">
            </div>
            <div class="col-md-4">
                <label class="form-label">Gmail Link URL</label>
                <input type="url" class="form-control" wire:model.blur="gmail_url"
                    placeholder="mailto:example@gmail.com or profile link">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save"><i class="bi bi-floppy me-1"></i>Save Settings</span>
                    <span wire:loading wire:target="save"><span
                            class="spinner-border spinner-border-sm me-1"></span>Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
