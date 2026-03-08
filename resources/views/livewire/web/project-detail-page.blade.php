<div>
    <section class="container">
        <div class="card border-0 shadow-sm overflow-hidden">
            @if ($project->cover_image_path)
                <img src="{{ route('media.show', ['path' => $project->cover_image_path], false) }}"
                    alt="{{ $project->title }}" style="width:100%;max-height:380px;object-fit:cover;">
            @endif
            <div class="card-body p-4 p-md-5">
                <a href="{{ route('web.projects') }}" class="small text-decoration-none">&larr; Back to Projects</a>
            <h1 class="h2 mt-2">{{ $project->title }}</h1>
            @if($project->services->isNotEmpty())
                <div class="mb-2">
                    @foreach($project->services as $serviceTag)
                        <a href="{{ route('web.services.show', ['service' => $serviceTag->slug ?: $serviceTag->id]) }}" class="badge text-bg-light border text-decoration-none">{{ $serviceTag->title }}</a>
                    @endforeach
                </div>
            @endif
            <p class="text-secondary">{{ $project->summary }}</p>
                @if ($project->details)
                    <div class="text-secondary mb-3">{!! nl2br(e($project->details)) !!}</div>
                @endif
                @if ($project->project_url)
                    <a href="{{ $project->project_url }}" target="_blank" rel="noopener"
                        class="btn btn-primary btn-sm mb-3">Visit Project</a>
                @endif

                @if ($project->images->isNotEmpty())
                    <h2 class="h5 mt-3">Project Gallery</h2>
                    <div class="row g-3">
                        @foreach ($project->images as $image)
                            <div class="col-md-3 col-6">
                                <img src="{{ route('media.show', ['path' => $image->image_path], false) }}"
                                    alt="Project image" class="img-fluid rounded border"
                                    style="height:140px;object-fit:cover;">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

</div>
