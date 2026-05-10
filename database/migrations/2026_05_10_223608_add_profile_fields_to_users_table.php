<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('blood_group')->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('blood_group');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->decimal('height', 5, 1)->nullable()->after('gender');
            $table->decimal('weight', 5, 1)->nullable()->after('height');
            $table->text('allergies')->nullable()->after('weight');
            $table->text('conditions')->nullable()->after('allergies');
            $table->text('medications')->nullable()->after('conditions');
            $table->boolean('notif_consultations')->default(true)->after('medications');
            $table->boolean('notif_lab_reports')->default(true)->after('notif_consultations');
            $table->boolean('notif_family_alerts')->default(true)->after('notif_lab_reports');
            $table->boolean('notif_tips')->default(false)->after('notif_family_alerts');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'blood_group', 'date_of_birth', 'gender',
                'height', 'weight', 'allergies', 'conditions', 'medications',
                'notif_consultations', 'notif_lab_reports', 'notif_family_alerts', 'notif_tips',
            ]);
        });
    }
};