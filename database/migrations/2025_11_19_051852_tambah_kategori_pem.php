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
        Schema::table('kategori_pembayaran', function (Blueprint $table) {
        $table->enum('frekuensi', ['bulanan', 'semester', 'tahunan'])->default('bulanan');
        $table->boolean('auto_generate')->default(true);
        $table->enum('status', ['active', 'inactive'])->default('active');

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
