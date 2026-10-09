<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    
public function up(): void
{
    Schema::table('treatments', function (Blueprint $table) {
        // Kolom category, min_price, dan max_price
        // sudah tersedia di database lokal.
        // Tidak perlu menambahkannya lagi.
    });
}


    public function down(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'min_price',
                'max_price',
            ]);
        });
    }
};