<div>
    <section class="container">
        <div class="card border-0 shadow-sm overflow-hidden">
            @if ($service->image_path)
                <img src="{{ route('media.show', ['path' => $service->image_path], false) }}" alt="{{ $service->title }}"
                    style="width:100%;max-height:360px;object-fit:cover;">
            @endif
            <div class="card-body p-4 p-md-5">
                <a href="{{ route('web.services') }}" class="small text-decoration-none">&larr; Back to Services</a>
                <h1 class="h2 mt-2">{{ $service->title }}</h1>
                @if ($service->price)
                    <p class="fw-semibold mb-3">${{ $service->price }}</p>
                @endif
                <p class="text-secondary">{{ $service->description }}</p>
                @if ($service->details)
                    <div class="text-secondary">{!! nl2br(e($service->details)) !!}</div>
                @endif
                @if($service->projects->isNotEmpty())
                    <hr>
                    <h2 class="h5">Projects Under This Service</h2>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($service->projects as $project)
                            <a href="{{ route('web.projects.show', ['project' => $project->slug ?: $project->id]) }}" class="badge text-bg-light border text-decoration-none">{{ $project->title }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

</div>
