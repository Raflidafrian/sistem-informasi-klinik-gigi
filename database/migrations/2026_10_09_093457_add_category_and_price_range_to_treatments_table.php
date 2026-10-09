<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->string('category')->nullable()->after('name');
            $table->decimal('min_price', 15, 2)->nullable()->after('price');
            $table->decimal('max_price', 15, 2)->nullable()->after('min_price');
        });

    // Salin harga lama ke rentang harga agar data lama tetap tersedia.
    DB::table('treatments')->update([
        'min_price' => DB::raw('price'),
        'max_price' => DB::raw('price'),
    ]);
}

    /**
     * Reverse the migrations.
     */
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