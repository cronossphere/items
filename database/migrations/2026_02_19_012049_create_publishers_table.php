<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('website')->nullable();
            $table->string('country', 2)->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->nullOnDelete();

            // Häufige Suche + Duplikatvermeidung pro Mandant
            $table->index(['organization_id', 'name']);
            // Name pro Mandant eindeutig (bei SoftDelete inkl deleted_at)
            $table->unique(['organization_id', 'name', 'deleted_at'], 'publishers_org_name_deleted_unique');

            $table->softDeletes();
            $table->timestamps();
        });
    }
};
