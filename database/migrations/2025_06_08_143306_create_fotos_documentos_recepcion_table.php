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
        Schema::create('documentos_recepcion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recepciones_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['orden_reparacion', 'cotizacion', 'factura', 'otro']);
            $table->string('numero_documento', 50)->nullable();
            $table->text('archivo_ruta');
            $table->date('fecha_emision')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos_documentos_recepcion');
    }
};
