<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('google_map_url')->nullable()->after('address');
            $table->string('youtube_url')->nullable()->after('linkedin_url');
            $table->string('tiktok_url')->nullable()->after('youtube_url');
            $table->string('gmail_url')->nullable()->after('tiktok_url');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn(['google_map_url', 'youtube_url', 'tiktok_url', 'gmail_url']);
        });
    }
};
