<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('family_member_id')->nullable()->constrained()->onDelete('set null');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('report_type')->nullable();
            $table->enum('status', ['pending', 'processing', 'analyzed', 'failed'])->default('pending');
            $table->json('ai_analysis')->nullable();
            $table->json('lab_values')->nullable();
            $table->text('summary')->nullable();
            $table->integer('abnormal_count')->default(0);
            $table->integer('normal_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_reports');
    }
};