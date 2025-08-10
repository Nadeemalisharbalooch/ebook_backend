<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->string('country_code', 2)->nullable();
            $table->string('fips_code', 10)->nullable();
            $table->string('iso2', 10)->nullable();
            $table->string('iso3166_2', 20)->nullable();
            $table->string('type')->nullable();
            $table->integer('level')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('native')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('timezone')->nullable();
            $table->string('flag')->nullable();
            $table->string('wikiDataId')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
