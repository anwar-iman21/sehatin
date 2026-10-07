<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        $passwordColumn = collect(Schema::getColumns('users'))
            ->firstWhere('name', 'password');

        if ($passwordColumn && !$passwordColumn['nullable']) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('password')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Existing OAuth users may have null passwords; do not make the column required.
    }
};
