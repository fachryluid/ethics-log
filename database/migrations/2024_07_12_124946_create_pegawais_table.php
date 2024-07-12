<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->string('nip', 18)->unique();
            $table->string('gender', 9);
            $table->string('class', 64); // pangkat / golongan asn
            $table->string('position', 64); // jabatan
            $table->string('department');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
