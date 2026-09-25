<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('doctors', 'bio')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->text('bio')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('doctors', 'bio')) {
            Schema::table('doctors', function (Blueprint $table) {
                $table->dropColumn('bio');
            });
        }
    }
};