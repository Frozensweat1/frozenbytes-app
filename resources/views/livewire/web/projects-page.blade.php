<div>
    <section class="container">
        <x-web.hero :page="$page" :defaultTitle="$page?->title ?? 'Projects'" :defaultSubtitle="$page?->excerpt ?? 'Selected implementations delivered by our team.'" />

        @if($services->isNotEmpty())
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h6 mb-3">Filter by Service</h2>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($services as $serviceFilter)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $serviceFilter->id }}" wire:model.live="selectedServices" id="serviceFilter{{ $serviceFilter->id }}">
                                <label class="form-check-label" for="serviceFilter{{ $serviceFilter->id }}">{{ $serviceFilter->title }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        @if ($project->cover_image_path)
                            <img src="{{ route('media.show', ['path' => $project->cover_image_path], false) }}"
                                class="card-img-top" alt="{{ $project->title }}" style="height: 220px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h2 class="h5">{{ $project->title }}</h2>
                            <p class="text-secondary">{{ $project->summary }}</p>
                            <a href="{{ route('web.projects.show', ['project' => $project->slug ?: $project->id]) }}"
                                class="btn btn-sm btn-outline-primary">View Details</a>
                            @if ($project->project_url)
                                <a href="{{ $project->project_url }}" class="btn btn-sm btn-outline-primary"
                                    target="_blank" rel="noopener">View Project</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No projects found for selected filters.</div>
            @endforelse
        </div>
    </section>
</div>
