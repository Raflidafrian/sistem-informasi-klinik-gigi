<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom role dan phone sudah dibuat
        // dalam migration create_users_table.
    }

    public function down(): void
    {
        // Tidak menghapus kolom karena
        // keduanya dimiliki migration pertama.
    }
};