@props(['page' => null, 'defaultTitle' => null, 'defaultSubtitle' => null, 'defaultCtaText' => null, 'defaultCtaUrl' => null])

@php
    $siteSetting = \App\Models\SiteSetting::current();
    $backgroundOne = $siteSetting->backgroundOneAssetUrl();
    $backgroundTwo = $siteSetting->backgroundTwoAssetUrl();

    $title = $page?->hero_title ?: ($defaultTitle ?: $page?->title);
    $subtitle = $page?->hero_subtitle ?: ($defaultSubtitle ?: $page?->excerpt);
    $ctaText = $page?->hero_cta_text ?: $defaultCtaText;
    $ctaUrl = $page?->hero_cta_url ?: $defaultCtaUrl;

    $slug = $page?->slug;
    $usePrimaryBackground = in_array($slug, ['home', 'services', 'blog'], true);
    $heroBackground = $usePrimaryBackground
        ? ($backgroundOne ?: $backgroundTwo)
        : ($backgroundTwo ?: $backgroundOne);

    $heroStyle = $heroBackground
        ? "background: linear-gradient(rgba(10,20,40,.60), rgba(10,20,40,.65)), url('{$heroBackground}') center/cover no-repeat;"
        : "background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);";
@endphp

@if($title || $subtitle)
    <section class="container mt-2 mb-5">
        <div class="p-5 rounded-4 text-white shadow-sm" style="{{ $heroStyle }}">
            @if($title)
                <h1 class="display-6 fw-bold mb-2">{{ $title }}</h1>
            @endif
            @if($subtitle)
                <p class="lead mb-0">{{ $subtitle }}</p>
            @endif
            @if($ctaText && $ctaUrl)
                <a href="{{ $ctaUrl }}" class="btn btn-light mt-3">{{ $ctaText }}</a>
            @endif
        </div>
    </section>
@endif
