<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique()->nullable();
            $table->enum('payment_method', [
                'online',
                'cash',
                'wp_receipt',
            ]);
            $table->integer('amount')->default(0);
            $table->foreignId('student_id')->constrained('students');
            $table->enum('status', [
                'pending',
                'paid',
                'due',
            ])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->enum('paid_month', [
                'january',
                'february',
                'march',
                'april',
                'may',
                'june',
                'july',
                'august',
                'september',
                'october',
                'november',
                'december',
            ])->nullable()->default(now()->format('F'));
            $table->enum('paid_year', [
                '2024',
                '2025',
                '2026',
                '2027',
                '2028',
                '2029',
                '2030',
            ])->nullable()->default(now()->format('Y'));
            $table->string('receipt_picture')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
