<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('alamat_pengiriman');
            $table->string('metode_pembayaran');
            $table->enum('status', ['menunggu_pembayaran', 'menunggu', 'diproses', 'ditolak', 'dikirim', 'selesai'])->default('menunggu_pembayaran');
            $table->integer('total_harga');
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
