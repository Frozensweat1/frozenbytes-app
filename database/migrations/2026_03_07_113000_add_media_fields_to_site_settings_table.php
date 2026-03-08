<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('logo_path')->nullable()->after('logo_url');
            $table->string('background_one_path')->nullable()->after('logo_path');
            $table->string('background_two_path')->nullable()->after('background_one_path');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn(['logo_path', 'background_one_path', 'background_two_path']);
        });
    }
};
