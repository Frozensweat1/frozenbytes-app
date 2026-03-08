<div>
    <section class="container">
        <x-web.hero :page="$page" :defaultTitle="$page?->title ?? 'Services'" :defaultSubtitle="$page?->excerpt ?? 'Explore our available service offerings.'" />
        <div class="row g-4">
            @forelse($services as $service)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        @if ($service->image_path)
                            <img src="{{ route('media.show', ['path' => $service->image_path], false) }}"
                                class="card-img-top" alt="{{ $service->title }}" style="height: 220px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h2 class="h5">{{ $service->title }}</h2>
                            <p class="text-secondary">{{ $service->description }}</p>
                            @if ($service->price)
                                <p class="mb-0 fw-semibold">${{ $service->price }}</p>
                            @endif
                            @if($service->projects->isNotEmpty())
                                <hr>
                                <h3 class="h6">Related Projects</h3>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($service->projects as $linkedProject)
                                        <a href="{{ route('web.projects.show', ['project' => $linkedProject->slug ?: $linkedProject->id]) }}" class="badge text-bg-light border text-decoration-none">{{ $linkedProject->title }}</a>
                                    @endforeach
                                </div>
                            @endif
                            <a href="{{ route('web.services.show', ['service' => $service->slug ?: $service->id]) }}"
                                class="btn btn-sm btn-outline-primary mt-2">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No services published yet.</div>
            @endforelse
        </div>
    </section>

</div>
