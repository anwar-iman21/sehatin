<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('sender', 16);
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'id']);
            $table->index(['sender', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_messages');
    }
};