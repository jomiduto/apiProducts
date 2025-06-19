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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nombre del producto');
            $table->text('description')->comment('Descripción del producto');
            $table->decimal('price', 10, 2)->comment('Precio del producto en la divisa base');
            $table->unsignedBigInteger('currency_id')->comment('Identificador de la divisa base');
            $table->decimal('tax_cost', 10, 2)->comment('Costo de impuestos del producto');
            $table->decimal('manufacturing_cost', 10, 2)->comment('Costo de fabricación del producto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
