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
        Schema::create('order_product', function (Blueprint $table) {
            // FK ke tabel orders
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                  ->references('id')->on('orders')
                  ->onDelete('cascade');

            // FK ke tabel products
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');

            // qty per item (default 1 agar tdk error saat attach tanpa kuantitas)
            $table->unsignedInteger('kuantitas')->default(1);

            // Composite primary key → mencegah satu product masuk dua kali di order yg sama
            $table->primary(['order_id', 'product_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
