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
            $table->string('offender', 32);
            $table->string('type', 64);
            $table->text('desc');
            $table->string('status', 16)->default(ViolationStatus::PENDING);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
