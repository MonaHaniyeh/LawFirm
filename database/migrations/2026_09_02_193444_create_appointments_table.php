<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained();
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('lawyer_id')->constrained('users');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('meeting_location')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'scheduled', 'completed', 'rejected'])->default('pending');
            $table->text('response')->nullable();
            $table->boolean('is_new')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
