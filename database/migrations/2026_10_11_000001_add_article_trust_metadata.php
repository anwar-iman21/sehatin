<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'reviewer_name')) {
                $table->string('reviewer_name')->nullable();
            }
            if (!Schema::hasColumn('articles', 'last_reviewed_at')) {
                $table->date('last_reviewed_at')->nullable();
            }
            if (!Schema::hasColumn('articles', 'references_json')) {
                $table->json('references_json')->nullable();
            }
        });

        Schema::create('article_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'article_id']);
        });

        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('query', 200);
            $table->timestamps();
            $table->unique(['user_id', 'query']);
            $table->index(['user_id', 'updated_at']);
        });

        Schema::create('community_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('category', 80);
            $table->string('title', 200);
            $table->text('body');
            $table->unsignedInteger('views')->default(0);
            $table->boolean('is_question')->default(false);
            $table->timestamps();
            $table->index(['category', 'created_at']);
        });

        Schema::create('community_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('community_threads')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('body');
            $table->boolean('doctor_verified')->default(false);
            $table->timestamps();
        });

        Schema::create('community_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->morphs('reportable');
            $table->string('reason', 80);
            $table->text('details')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_verified_doctor')) {
                $table->boolean('is_verified_doctor')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_verified_doctor')) {
                $table->dropColumn('is_verified_doctor');
            }
        });
        Schema::dropIfExists('community_reports');
        Schema::dropIfExists('community_replies');
        Schema::dropIfExists('community_threads');
        Schema::dropIfExists('search_histories');
        Schema::dropIfExists('article_bookmarks');
        Schema::table('articles', function (Blueprint $table) {
            $columns = array_filter(
                ['reviewer_name', 'last_reviewed_at', 'references_json'],
                fn (string $column): bool => Schema::hasColumn('articles', $column)
            );
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
