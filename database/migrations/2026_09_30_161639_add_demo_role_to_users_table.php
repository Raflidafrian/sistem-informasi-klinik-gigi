<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite digunakan oleh automated test.
        // SQLite tidak mendukung ALTER TABLE ... MODIFY seperti MySQL.
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin', 'dokter', 'pasien', 'demo')
            NOT NULL DEFAULT 'pasien'
        ");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin', 'dokter', 'pasien')
            NOT NULL DEFAULT 'pasien'
        ");
    }
};