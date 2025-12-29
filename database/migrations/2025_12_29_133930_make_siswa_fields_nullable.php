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
        Schema::table('siswa', function (Blueprint $table) {
            // Make fields that were previously required to be nullable
            $table->string('nis')->nullable()->change();
            $table->string('nik')->nullable()->change();
            $table->string('tahun_ajaran')->nullable()->change();
            $table->string('kelas')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('tempat_lahir')->nullable()->change();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            // Revert the fields back to required (original state)
            $table->string('nis')->nullable(false)->change();
            $table->string('nik')->nullable(false)->change();
            $table->string('tahun_ajaran')->nullable(false)->change();
            $table->string('kelas')->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->string('tempat_lahir')->nullable(false)->change();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable(false)->change();
        });
    }
};
