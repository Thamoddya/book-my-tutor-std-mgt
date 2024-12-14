<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('reg_no')->unique();
            $table->string('name');
            $table->string('call_no')->nullable();
            $table->string('wtp_no')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('batch_id')->nullable()->constrained('batches');
            $table->foreignId('school_id')->nullable()->constrained('schools');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
