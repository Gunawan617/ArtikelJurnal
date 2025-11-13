<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('author_title')->nullable()->after('author'); // Gelar: Dr., Prof., dll
            $table->text('author_bio')->nullable()->after('author_title'); // Bio singkat
            $table->string('author_photo')->nullable()->after('author_bio'); // Foto profil
            $table->string('author_institution')->nullable()->after('author_photo'); // Institusi
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['author_title', 'author_bio', 'author_photo', 'author_institution']);
        });
    }
};
