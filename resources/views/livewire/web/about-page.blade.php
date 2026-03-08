<div>
    <section class="container">
        <x-web.hero :page="$aboutPage" :defaultTitle="$aboutPage?->title ?? 'About ' . $site->business_name" :defaultSubtitle="$aboutPage?->excerpt ??
            ($site->tagline ?: 'We deliver dependable web engineering and long-term product support.')" />

        <div class="bg-white p-5 rounded-4 shadow-sm">
            <p class="text-secondary mb-0">
                {{ $aboutPage?->content ?? 'Use the admin Page Management section to customize this About page content.' }}
            </p>
        </div>
    </section>

</div>
