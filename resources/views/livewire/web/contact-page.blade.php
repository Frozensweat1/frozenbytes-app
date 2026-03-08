<div>
    <section class="container">
        <x-web.hero :page="$page" :defaultTitle="$page?->title ?? 'Contact Us'" :defaultSubtitle="$page?->excerpt ?? 'Tell us about your project and we will reply with a plan.'" />

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        @if ($page?->content)
                            <p class="text-secondary">{{ $page->content }}</p>
                        @endif

                        <form wire:submit="submitInquiry" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" wire:model.blur="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" wire:model.blur="email">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Phone (Optional)</label>
                                <input type="text" class="form-control" wire:model.blur="phone">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" rows="5" wire:model.blur="message"></textarea>
                                @error('message')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    wire:target="submitInquiry">
                                    <span wire:loading.remove wire:target="submitInquiry"><i
                                            class="bi bi-send-check me-1"></i>Send Inquiry</span>
                                    <span wire:loading wire:target="submitInquiry"><span
                                            class="spinner-border spinner-border-sm me-1"></span>Sending...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Contact Details</h2>
                        @if ($site->support_email)
                            <p class="mb-2"><i class="bi bi-envelope me-2"></i><a
                                    href="mailto:{{ $site->support_email }}">{{ $site->support_email }}</a></p>
                        @endif
                        @if ($site->support_phone)
                            <p class="mb-2"><i class="bi bi-telephone me-2"></i>{{ $site->support_phone }}</p>
                        @endif
                        @if ($site->address)
                            <p class="mb-2"><i class="bi bi-geo-alt me-2"></i>{{ $site->address }}</p>
                        @endif

                        <h3 class="h6 mt-4">Social Links</h3>
                        <div class="d-flex flex-wrap gap-2">
                            @if ($site->facebook_url)
                                <a class="btn btn-outline-secondary btn-sm" href="{{ $site->facebook_url }}"
                                    target="_blank" rel="noopener"><i class="bi bi-facebook me-1"></i>Facebook</a>
                            @endif
                            @if ($site->instagram_url)
                                <a class="btn btn-outline-secondary btn-sm" href="{{ $site->instagram_url }}"
                                    target="_blank" rel="noopener"><i class="bi bi-instagram me-1"></i>Instagram</a>
                            @endif
                            @if ($site->linkedin_url)
                                <a class="btn btn-outline-secondary btn-sm" href="{{ $site->linkedin_url }}"
                                    target="_blank" rel="noopener"><i class="bi bi-linkedin me-1"></i>LinkedIn</a>
                            @endif
                            @if ($site->youtube_url)
                                <a class="btn btn-outline-secondary btn-sm" href="{{ $site->youtube_url }}"
                                    target="_blank" rel="noopener"><i class="bi bi-youtube me-1"></i>YouTube</a>
                            @endif
                            @if ($site->tiktok_url)
                                <a class="btn btn-outline-secondary btn-sm" href="{{ $site->tiktok_url }}"
                                    target="_blank" rel="noopener"><i class="bi bi-tiktok me-1"></i>TikTok</a>
                            @endif
                            @if ($site->gmail_url)
                                <a class="btn btn-outline-secondary btn-sm" href="{{ $site->gmail_url }}"
                                    target="_blank" rel="noopener"><i class="bi bi-envelope-at me-1"></i>Gmail</a>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($site->google_map_url)
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Location Map</h2>
                            <iframe src="{{ $site->google_map_url }}" class="w-100 rounded border"
                                style="height: 280px;" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

</div>
