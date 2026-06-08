<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('username')->unique(); // ← TAMBAH INI
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('role')->default('student'); // ← TAMBAH INI
        $table->string('avatar')->nullable();       // ← TAMBAH INI (opsional)
        $table->rememberToken();
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
