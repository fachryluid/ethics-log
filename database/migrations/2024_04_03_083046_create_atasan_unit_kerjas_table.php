<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atasan_unit_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('unit_kerja_id')->constrained('unit_kerjas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atasan_unit_kerjas');
    }
};
