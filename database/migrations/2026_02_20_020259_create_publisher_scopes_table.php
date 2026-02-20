<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('publisher_scopes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('publisher_id')->constrained('publishers')->cascadeOnDelete();

            $table->string('scope');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['organization_id', 'publisher_id', 'scope', 'deleted_at'],
                'publisher_scopes_unique'
            );

            $table->index(['organization_id', 'scope']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publisher_scopes');
    }
};
