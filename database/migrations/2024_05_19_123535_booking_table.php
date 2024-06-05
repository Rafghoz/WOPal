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
        Schema::create('tb_booking', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_nk');
            $table->string('catatan');
            $table->foreignid('id_package')->constrained('tb_packages');
            $table->foreignid('id_user')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_booking');
    }
};
