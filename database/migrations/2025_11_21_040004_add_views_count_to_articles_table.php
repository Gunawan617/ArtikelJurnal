<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedInteger('views_count')->default(0)->after('is_featured');

            // Add indexes for performance
            $table->index('views_count');
            $table->index(['is_published', 'views_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'views_count']);
            $table->dropIndex(['views_count']);
            $table->dropColumn('views_count');
        });
    }
};
