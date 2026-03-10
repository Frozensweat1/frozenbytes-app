<?php

namespace App\Console\Commands;

use App\Jobs\PublishAiBlogPostJob;
use App\Models\BlogPost;
use Illuminate\Console\Command;
use Throwable;

class GenerateDailyBlogPost extends Command
{
    protected $signature = 'blog:generate-daily {--now : Run synchronously instead of queueing}';

    protected $description = 'Generate and publish one AI blog post based on services.';

    public function handle(): int
    {
        if ($this->option('now')) {
            try {
                $job = new PublishAiBlogPostJob(true);
                $createdPost = app()->call([$job, 'handle']);

                if ($createdPost instanceof BlogPost) {
                    $this->info("AI blog post created: #{$createdPost->id} {$createdPost->title}");
                } else {
                    $this->warn('AI daily blog generation completed with no new post created.');
                }

                return self::SUCCESS;
            } catch (Throwable $exception) {
                $this->error('AI daily blog generation failed: '.$exception->getMessage());

                return self::FAILURE;
            }

        }

        PublishAiBlogPostJob::dispatch();
        $this->info('AI daily blog generation job queued.');

        return self::SUCCESS;
    }
}
