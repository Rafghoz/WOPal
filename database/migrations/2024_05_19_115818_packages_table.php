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
        Schema::create('tb_packages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->integer('harga');
            $table->string('gmb_paket');
            $table->text('deskrisi');
            $table->foreignId('id_wedding')->nullable()->constrained('tb_wopal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_packages');
    }
};
