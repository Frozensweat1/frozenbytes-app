<div>
    <section class="container">
        <x-web.hero :page="$homePage" :defaultTitle="'Build, Scale, and Grow with ' . $site->business_name" :defaultSubtitle="$site->tagline ?: 'Reliable digital products for growth-focused companies.'" defaultCtaText="Start Your Project"
            :defaultCtaUrl="route('web.contact')" />

        @if ($homePage?->content)
            <div class="p-4 bg-white rounded-4 shadow-sm mb-4">
                <p class="text-secondary mb-0">{{ $homePage->content }}</p>
            </div>
        @endif

        <h2 class="h4 mb-3">Featured Services</h2>
        <div class="row g-4 mb-4">
            @forelse($services as $service)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5">{{ $service->title }}</h3>
                            <p class="text-secondary mb-0">{{ $service->description }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No services published yet.</div>
            @endforelse
        </div>

        <h2 class="h4 mb-3">Recent Projects</h2>
        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5">{{ $project->title }}</h3>
                            <p class="text-secondary mb-0">{{ $project->summary }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-secondary">No projects published yet.</div>
            @endforelse
        </div>
    </section>

</div>
