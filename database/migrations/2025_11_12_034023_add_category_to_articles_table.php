<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('category')->default('ARTIKEL ILMIAH')->after('title');
            $table->string('category_color')->default('orange')->after('category'); // orange, blue, green, red, purple
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['category', 'category_color']);
        });
    }
};
