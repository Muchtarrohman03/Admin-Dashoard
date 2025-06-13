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
        Schema::create('services', function (Blueprint $table) {
        $table->string('service_id')->primary(); // ID custom sebagai primary
        $table->date('tanggal_masuk');
        $table->string('owner');
        $table->text('kendala');
        $table->string('penggantian_part');
        $table->string('tipe');
        $table->integer('serial_number');
        $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
