<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!Schema::hasColumn('categories', 'icon')) {
                    $table->string('icon')->nullable();
                }
                if (!Schema::hasColumn('categories', 'is_featured')) {
                    $table->boolean('is_featured')->default(false);
                }
                if (!Schema::hasColumn('categories', 'order')) {
                    $table->integer('order')->default(0);
                }
            });
        }

        if (Schema::hasTable('articles')) {
            $addUserId = !Schema::hasColumn('articles', 'user_id');
            $copyImage = !Schema::hasColumn('articles', 'thumbnail')
                && Schema::hasColumn('articles', 'image');

            Schema::table('articles', function (Blueprint $table) use ($addUserId) {
                if ($addUserId) {
                    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                }
                if (!Schema::hasColumn('articles', 'thumbnail')) {
                    $table->string('thumbnail')->nullable();
                }
                if (!Schema::hasColumn('articles', 'meta_description')) {
                    $table->string('meta_description')->nullable();
                }
            });

            if ($copyImage) {
                DB::table('articles')
                    ->whereNull('thumbnail')
                    ->update(['thumbnail' => DB::raw('image')]);
            }

            if ($addUserId && Schema::hasColumn('articles', 'author')) {
                DB::table('articles')
                    ->select('id', 'author')
                    ->whereNull('user_id')
                    ->orderBy('id')
                    ->chunkById(200, function ($articles) {
                        foreach ($articles as $article) {
                            if (!$article->author) {
                                continue;
                            }

                            $userId = DB::table('users')
                                ->where('name', $article->author)
                                ->value('id');

                            if ($userId) {
                                DB::table('articles')
                                    ->where('id', $article->id)
                                    ->update(['user_id' => $userId]);
                            }
                        }
                    });
            }
        }

        if (Schema::hasTable('services')) {
            $addActive = !Schema::hasColumn('services', 'is_active');
            $addOrder = !Schema::hasColumn('services', 'order');
            $copySortOrder = $addOrder && Schema::hasColumn('services', 'sort_order');

            Schema::table('services', function (Blueprint $table) use ($addActive, $addOrder) {
                if (!Schema::hasColumn('services', 'image')) {
                    $table->string('image')->nullable();
                }
                if ($addActive) {
                    $table->boolean('is_active')->default(true);
                }
                if ($addOrder) {
                    $table->integer('order')->default(0);
                }
            });

            if ($copySortOrder) {
                DB::table('services')->update(['order' => DB::raw('sort_order')]);
            }
            if ($addActive && Schema::hasColumn('services', 'status')) {
                DB::table('services')
                    ->whereIn(DB::raw('LOWER(status)'), ['inactive', 'draft', 'disabled', '0', 'false'])
                    ->update(['is_active' => false]);
            }
        }

        if (Schema::hasTable('faqs')) {
            $addActive = !Schema::hasColumn('faqs', 'is_active');
            $addOrder = !Schema::hasColumn('faqs', 'order');
            $copySortOrder = $addOrder && Schema::hasColumn('faqs', 'sort_order');

            Schema::table('faqs', function (Blueprint $table) use ($addActive, $addOrder) {
                if ($addActive) {
                    $table->boolean('is_active')->default(true);
                }
                if ($addOrder) {
                    $table->integer('order')->default(0);
                }
            });

            if ($copySortOrder) {
                DB::table('faqs')->update(['order' => DB::raw('sort_order')]);
            }
            if ($addActive && Schema::hasColumn('faqs', 'status')) {
                DB::table('faqs')
                    ->whereIn(DB::raw('LOWER(status)'), ['inactive', 'draft', 'disabled', '0', 'false'])
                    ->update(['is_active' => false]);
            }
        }
    }

    public function down(): void
    {
        // Compatibility columns may now contain application data; keep them intact.
    }
};
