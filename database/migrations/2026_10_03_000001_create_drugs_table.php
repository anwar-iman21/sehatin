<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('generic_name')->nullable();
            $table->string('category');
            $table->string('form');
            $table->string('manufacturer')->nullable();
            $table->text('content');
            $table->text('indication')->nullable();
            $table->text('dosage')->nullable();
            $table->text('how_to_use')->nullable();
            $table->text('side_effects')->nullable();
            $table->text('contraindication')->nullable();
            $table->text('warning')->nullable();
            $table->string('price_range')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['is_active', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
