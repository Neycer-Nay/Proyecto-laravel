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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['Empresa', 'Persona']);
            $table->enum('tipo_documento', ['CI', 'NIT', 'Pasaporte', 'Otro'])->nullable();
            $table->string('documento', 50)->nullable();
            $table->string('telefono', 50);
            $table->string('email')->nullable();
            $table->text('direccion')->nullable();
            $table->string('ciudad', 100)->default('Santa Cruz');
            $table->string('pais', 100)->default('Bolivia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
