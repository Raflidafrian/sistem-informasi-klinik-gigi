<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom role dan phone sudah ada
        // dalam create_users_table.
    }

    public function down(): void
    {
        // Tidak perlu menghapus kolom.
    }
};