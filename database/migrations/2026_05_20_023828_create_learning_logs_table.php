<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stage_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('roadmap_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('duration_minutes')->default(0);
            $table->date('log_date');
            $table->string('activity')->default('study'); // study, review, quiz
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_logs');
    }
};
