<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn')->nullable()->after('author');
            $table->date('published_at')->nullable()->after('isbn');
            $table->softDeletes(); // adds deleted_at
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'published_at']);
            $table->dropSoftDeletes();
        });
    }
};
