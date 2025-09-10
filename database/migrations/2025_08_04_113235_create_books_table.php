<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
	Schema::create('books', function (Blueprint $table) {
    	$table->id();
    	$table->string('title');
    	$table->string('author');
    	$table->text('description')->nullable();
    	$table->decimal('price', 8, 2)->nullable();
    	$table->string('pdf_url')->nullable();
    	$table->unsignedBigInteger('category_id')->nullable(); // bez FK za sada
    	$table->timestamps();
	
	});

    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
