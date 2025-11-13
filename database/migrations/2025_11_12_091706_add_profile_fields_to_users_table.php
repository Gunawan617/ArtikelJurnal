<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('title')->nullable()->after('name'); // Gelar: Dr., Prof., M.Kom, dll
            $table->string('institution')->nullable()->after('title'); // Institusi/Universitas
            $table->text('bio')->nullable()->after('institution'); // Bio singkat
            $table->string('photo')->nullable()->after('bio'); // Foto profil
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['title', 'institution', 'bio', 'photo']);
        });
    }
};
