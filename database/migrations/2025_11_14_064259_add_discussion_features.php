<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom is_closed ke discussions
        Schema::table('discussions', function (Blueprint $table) {
            $table->boolean('is_closed')->default(false)->after('last_reply_at');
        });

        // Tambah kolom is_banned ke users
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_banned')->default(false)->after('role');
            $table->timestamp('banned_at')->nullable()->after('is_banned');
            $table->text('ban_reason')->nullable()->after('banned_at');
        });
    }

    public function down(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->dropColumn('is_closed');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_banned', 'banned_at', 'ban_reason']);
        });
    }
};
