<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // user_id sudah dibuat pada
        // create_doctors_table.
    }

    public function down(): void
    {
        // Tidak menghapus user_id karena
        // kolom ini milik migration pertama.
    }
};