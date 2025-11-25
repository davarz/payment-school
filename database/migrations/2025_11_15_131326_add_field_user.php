<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nis')->unique()->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->enum('status_siswa', ['aktif', 'pindah', 'dikeluarkan'])->default('aktif');
            $table->string('kelas')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nis', 'nik', 'tahun_ajaran', 'status_siswa', 
                'kelas', 'alamat', 'telepon', 'tanggal_lahir', 'tempat_lahir'
            ]);
        });
    }
};