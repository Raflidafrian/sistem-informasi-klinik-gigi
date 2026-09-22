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
    Schema::table('patients', function (Blueprint $table) {

        $table->foreignId('user_id')
            ->after('id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->string('nik', 16)
            ->nullable()
            ->unique()
            ->after('user_id');

        $table->date('birth_date')
            ->nullable()
            ->after('nik');

        $table->enum('gender', ['male', 'female'])
            ->nullable()
            ->after('birth_date');

        $table->text('address')
            ->nullable()
            ->after('gender');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('patients', function (Blueprint $table) {

        $table->dropForeign(['user_id']);

        $table->dropColumn([
            'user_id',
            'nik',
            'birth_date',
            'gender',
            'address',
        ]);

    });
}
};