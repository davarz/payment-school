<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_pembayaran_id')->constrained('kategori_pembayaran')->onDelete('cascade');
            $table->decimal('jumlah_tagihan', 15, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status', ['unpaid', 'pending', 'paid', 'canceled'])->default('unpaid');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};