<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table): void {
            $table->string('hero_title')->nullable()->after('content');
            $table->string('hero_subtitle')->nullable()->after('hero_title');
            $table->string('hero_cta_text')->nullable()->after('hero_subtitle');
            $table->string('hero_cta_url')->nullable()->after('hero_cta_text');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table): void {
            $table->dropColumn(['hero_title', 'hero_subtitle', 'hero_cta_text', 'hero_cta_url']);
        });
    }
};
