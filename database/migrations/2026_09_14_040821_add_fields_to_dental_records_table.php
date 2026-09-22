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
        Schema::table('dental_records', function (Blueprint $table) {

            $table->foreignId('appointment_id')
                ->after('id')
                ->constrained('appointments')
                ->cascadeOnDelete();

            $table->foreignId('patient_id')
                ->after('appointment_id')
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->foreignId('doctor_id')
                ->after('patient_id')
                ->constrained('doctors')
                ->cascadeOnDelete();

            $table->json('odontogram_data')
                ->nullable()
                ->after('doctor_id');

            $table->text('diagnosis')
                ->nullable()
                ->after('odontogram_data');

            $table->text('treatment')
                ->nullable()
                ->after('diagnosis');

            $table->text('notes')
                ->nullable()
                ->after('treatment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dental_records', function (Blueprint $table) {

            $table->dropForeign(['appointment_id']);
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['doctor_id']);

            $table->dropColumn([
                'appointment_id',
                'patient_id',
                'doctor_id',
                'odontogram_data',
                'diagnosis',
                'treatment',
                'notes',
            ]);
        });
    }
};