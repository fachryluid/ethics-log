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
            $table->string('department', 64); // unit kerja
            $table->text('desc');
            $table->string('evidence');
            $table->string('status', 32)->default(ViolationStatus::PENDING);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
