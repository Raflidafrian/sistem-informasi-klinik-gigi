<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin', 'dokter', 'pasien', 'demo')
            NOT NULL DEFAULT 'pasien'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin', 'dokter', 'pasien')
            NOT NULL DEFAULT 'pasien'
        ");
    }
};