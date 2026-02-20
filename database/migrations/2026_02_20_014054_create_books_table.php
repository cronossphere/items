<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('subtitle')->nullable();
            $table->string('isbn')->nullable();
            $table->string('cover')->nullable();
            $table->string('notes')->nullable();
            $table->integer('pages')->nullable();
            $table->string('language')->nullable();
            $table->integer('year')->nullable();

            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->foreignId('publisher_id')->constrained('publishers')->cascadeOnDelete();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->nullOnDelete();
            $table->softDeletes();

            $table->timestamps();
        });
    }
};
