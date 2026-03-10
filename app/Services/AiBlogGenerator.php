<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\Service;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class AiBlogGenerator
{
    public function generateFromService(Service $service): array
    {
        $provider = (string) config('services.ai.provider', 'deepseek');
        $provider = strtolower($provider);

        $apiKey = (string) (
            config('services.ai.api_key')
            ?: config("services.{$provider}.api_key")
            ?: config('services.groq.api_key')
            ?: config('services.deepseek.api_key')
            ?: config('services.openai.api_key')
        );
        if (!$apiKey) {
            throw new RuntimeException(strtoupper($provider).' API key is not configured.');
        }

        $defaultModel = match ($provider) {
            'groq' => 'llama-3.3-70b-versatile',
            'deepseek' => 'deepseek-chat',
            default => 'gpt-4.1-mini',
        };
        $defaultBaseUrl = match ($provider) {
            'groq' => 'https://api.groq.com/openai/v1',
            'deepseek' => 'https://api.deepseek.com/v1',
            default => 'https://api.openai.com/v1',
        };

        $model = (string) (
            config('services.ai.model')
            ?: config("services.{$provider}.model")
            ?: config('services.groq.model')
            ?: config('services.deepseek.model')
            ?: config('services.openai.model')
            ?: $defaultModel
        );

        $baseUrl = rtrim((string) (
            config('services.ai.base_url')
            ?: config("services.{$provider}.base_url")
            ?: config('services.groq.base_url')
            ?: config('services.deepseek.base_url')
            ?: config('services.openai.base_url')
            ?: $defaultBaseUrl
        ), '/');

        $prompt = $this->buildPrompt($service);

        $payload = [
            'model' => $model,
            'temperature' => 0.7,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an SEO blog writer. Return only valid JSON.',
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ];

        if (in_array($provider, ['openai', 'groq'], true)) {
            $payload['response_format'] = ['type' => 'json_object'];
        }

        $response = Http::timeout(120)
            ->withToken($apiKey)
            ->acceptJson()
            ->post($baseUrl.'/chat/completions', $payload);

        if ($response->failed()) {
            throw new RuntimeException(ucfirst($provider).' request failed: '.$response->body());
        }

        $content = (string) data_get($response->json(), 'choices.0.message.content', '');
        $payload = json_decode($content, true);
        if (!is_array($payload)) {
            throw new RuntimeException(ucfirst($provider).' response is not valid JSON.');
        }

        $title = trim((string) ($payload['title'] ?? ''));
        $excerpt = trim((string) ($payload['excerpt'] ?? ''));
        $articleBody = trim((string) ($payload['content'] ?? ''));

        if ($title === '' || $excerpt === '' || $articleBody === '') {
            throw new RuntimeException('AI response is missing required fields.');
        }

        if (Str::length($articleBody) < 900) {
            throw new RuntimeException('Generated article is too short for publish quality.');
        }

        $slug = Str::slug($title);
        if ($slug === '') {
            $slug = 'blog-'.now()->format('YmdHis');
        }

        $slug = $this->uniqueSlug($slug);

        $hash = sha1(Str::lower(strip_tags($articleBody)));
        $duplicateByContent = BlogPost::query()
            ->latest()
            ->limit(20)
            ->get()
            ->contains(function (BlogPost $post) use ($hash): bool {
                return sha1(Str::lower(strip_tags((string) $post->content))) === $hash;
            });

        if ($duplicateByContent) {
            throw new RuntimeException('Generated content duplicates recent posts.');
        }

        return [
            'title' => $title,
            'slug' => $slug,
            'excerpt' => Str::limit($excerpt, 255, ''),
            'content' => $articleBody,
            'is_published' => true,
            'published_at' => now(),
        ];
    }

    private function buildPrompt(Service $service): string
    {
        $serviceName = $service->title;
        $serviceSummary = trim(($service->description ?? '')."\n\n".($service->details ?? ''));

        return <<<PROMPT
Write one original SEO blog post for our business website based on this service:
Service Name: {$serviceName}
Service Context: {$serviceSummary}

Constraints:
- English
- Practical and professional tone
- 900-1600 characters minimum in the content body
- Avoid hype and fake guarantees
- Include useful subheadings in markdown (##)
- Include internal mention of related services/projects in a natural way
- No plagiarism

Return STRICT JSON object only with keys:
- title
- excerpt
- content
PROMPT;
    }

    private function uniqueSlug(string $baseSlug): string
    {
        $slug = $baseSlug;
        $counter = 2;

        while (BlogPost::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
