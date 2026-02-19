<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('publishables', function (Blueprint $table) {
            $table->id();

            $table->foreignId('org_id')->constrained()->cascadeOnDelete();
            $table->foreignId('publisher_id')->constrained('publishers')->cascadeOnDelete();
            $table->morphs('publishable'); // morphs: publishable_type (string) + publishable_id (unsignedBigInteger) + index

            $table->unique([
                'orga_id',
                'publisher_id',
                'publishable_type',
                'publishable_id',
            ], 'publishables_org_pub_entity_unique');

            $table->index([
                'org_id',
                'publishable_type',
                'publishable_id',
            ], 'publishables_org_entity_index');

            $table->index([
                'org_id',
                'publisher_id',
            ], 'publishables_org_publisher_index');

            $table->timestamps();
        });
    }
};
