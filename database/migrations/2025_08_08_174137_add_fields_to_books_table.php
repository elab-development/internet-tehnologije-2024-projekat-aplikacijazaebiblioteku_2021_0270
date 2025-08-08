public function up(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->string('title');
        $table->string('author');
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2)->nullable();
        $table->string('pdf_url'); // putanja/link do PDF-a
        $table->foreignId('category_id')->constrained()->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::table('books', function (Blueprint $table) {
        $table->dropConstrainedForeignId('category_id');
        $table->dropColumn(['title','author','description','price','pdf_url']);
    });
}
