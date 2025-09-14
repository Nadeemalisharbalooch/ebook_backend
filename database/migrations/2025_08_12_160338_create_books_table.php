<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            // Company / Tenancy scope
           $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Categories
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->nullOnDelete();

            // Book details
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discount_price', 10, 2)->nullable();

            // Media
            $table->string('cover_image')->nullable();
            $table->json('images')->nullable();

            // Extra details
            $table->string('language')->nullable();
            $table->string('isbn')->nullable()->unique();

            $table->string('edition')->nullable();
            $table->integer('pages')->nullable();
            $table->string('dimensions')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->enum('type', ['hard', 'soft', 'audio', 'video'])->default('hard');
            $table->enum('status', ['draft', 'published'])->default('draft');

            // Stock
            $table->integer('stock_quantity')->default(0);

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
