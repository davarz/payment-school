<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nis')->unique();
            $table->string('nik')->unique();
            $table->string('nisn')->unique()->nullable();
            $table->string('tahun_ajaran');
            $table->enum('status_siswa', ['aktif', 'pindah', 'dikeluarkan', 'lulus'])->default('aktif');
            $table->string('kelas');
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nama_wali')->nullable();
            $table->string('telepon_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes untuk performa query
            $table->index(['status_siswa', 'kelas']);
            $table->index('tahun_ajaran');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};