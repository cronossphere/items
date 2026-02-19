<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            // falls nicht vorhanden
            $table->foreignId('organization_id')
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->after('organization_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->softDeletes();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->unique(
                ['organization_id', 'type', 'slug', 'deleted_at'],
                'tags_org_type_slug_deleted_unique'
            );

            $table->index(['organization_id', 'type'], 'tags_org_type_index');
        });
    }

    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropIndex('tags_org_type_index');
            $table->dropUnique('tags_org_type_slug_deleted_unique');

            $table->dropSoftDeletes();

            $table->dropConstrainedForeignId('created_by');
            $table->dropConstrainedForeignId('organization_id');
        });
    }
};
