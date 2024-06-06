<?php

use App\Constants\ViolationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->date('date');
            $table->string('nip', 18)->nullable()->unique();
            $table->string('offender', 32);
            $table->string('type', 64);
            $table->string('class', 64)->nullable(); // pangkat / golongan asn
            $table->string('position', 64)->nullable(); // jabatan
            $table->foreignId('department')->constrained('unit_kerjas')->onDelete('cascade');
            $table->text('desc');
            $table->string('evidence');
            $table->string('status', 32)->default(ViolationStatus::PENDING);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('place');
            $table->string('regulation_section', 3)->nullable(); // Ketantuan Pasal
            $table->string('regulation_letter', 3)->nullable(); // Ketentuan Huruf
            $table->string('regulation_number', 32)->nullable(); // Nomor Peraturan Menteri
            $table->string('regulation_year', 4)->nullable(); // Tahun Peraturan Menteri
            $table->string('regulation_about')->nullable(); // Tentang Peraturan Menteri
            $table->string('examination_place')->nullable(); // Tempat Pemeriksaan
            $table->string('examination_date')->nullable(); // Tanggal Pemeriksaan
            $table->string('examination_time')->nullable(); // Waktu Pemeriksaan
            $table->string('examination_report')->nullable(); // Waktu Pemeriksaan
            $table->string('examination_result')->nullable(); // Waktu Pemeriksaan
            $table->date('session_date')->nullable(); // Tanggal Sidang
            $table->string('session_decision_report')->nullable(); // Putusan Sidang
            $table->string('session_official_report')->nullable(); // Berita Acara
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
