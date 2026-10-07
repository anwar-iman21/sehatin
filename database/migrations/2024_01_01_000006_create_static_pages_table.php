<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('static_pages')) {
            return;
        }

        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // about, privacy-policy, terms
            $table->string('title');
            $table->longText('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // This table may predate the migration; preserve its data on rollback.
    }
};
