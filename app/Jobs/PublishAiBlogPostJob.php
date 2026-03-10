<?php

namespace App\Jobs;

use App\Models\BlogPost;
use App\Models\Service;
use App\Services\AiBlogGenerator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class PublishAiBlogPostJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private bool $throwOnError = false)
    {
    }

    public function handle(AiBlogGenerator $generator): ?BlogPost
    {
        $service = Service::query()
            ->where('is_published', true)
            ->inRandomOrder()
            ->first();

        if (!$service) {
            Log::warning('AI blog publish skipped: no published service found.');

            if ($this->throwOnError) {
                throw new RuntimeException('AI blog publish skipped: no published service found.');
            }

            return null;
        }

        try {
            $post = $generator->generateFromService($service);
            return BlogPost::query()->create($post);
        } catch (\Throwable $exception) {
            Log::error('AI blog publish failed', [
                'message' => $exception->getMessage(),
                'service_id' => $service->id,
            ]);

            if ($this->throwOnError) {
                throw $exception;
            }
        }

        return null;
    }
}
