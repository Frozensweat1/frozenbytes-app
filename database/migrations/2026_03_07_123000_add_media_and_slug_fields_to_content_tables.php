<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->longText('details')->nullable()->after('description');
            $table->string('image_path')->nullable()->after('details');
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->longText('details')->nullable()->after('summary');
            $table->string('cover_image_path')->nullable()->after('details');
        });

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->string('featured_image_path')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->dropColumn(['slug', 'details', 'image_path']);
        });

        Schema::table('projects', function (Blueprint $table): void {
            $table->dropColumn(['slug', 'details', 'cover_image_path']);
        });

        Schema::table('blog_posts', function (Blueprint $table): void {
            $table->dropColumn(['featured_image_path']);
        });
    }
};
