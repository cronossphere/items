<?php

// database/migrations/xxxx_xx_xx_add_latest_organization_id_to_users.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('latest_organization_id')
                ->nullable()
                ->constrained('organizations')
                ->nullOnDelete()
                ->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('latest_organization_id');
        });
    }
};
