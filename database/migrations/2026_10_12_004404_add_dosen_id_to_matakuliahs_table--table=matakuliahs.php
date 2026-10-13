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
      // up()
        Schema::table('matakuliahs', function (Blueprint $table) {
            $table->foreignId('dosen_id')->nullable()->after('semester')
                ->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    // down()
    Schema::table('matakuliahs', function (Blueprint $table) {
        $table->dropConstrainedForeignId('dosen_id');
    });
    }
};
