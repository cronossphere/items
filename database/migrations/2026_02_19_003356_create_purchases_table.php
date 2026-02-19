<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date')->nullable();
            $table->text('warrenty_note')->nullable();
            $table->date('warrenty_date')->nullable();
            $table->string('serial_number')->nullable();
            $table->integer('price_cent')->default(0)->nullable();
            $table->tinyInteger('count')->default(1);
            $table->boolean('was_gifted')->default(false);
            $table->text('gifted_note')->nullable();
            $table->string('receipt')->nullable();

            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->nullOnDelete();

            $table->softDeletesDatetime();
            $table->timestamps();
        });
    }
};
