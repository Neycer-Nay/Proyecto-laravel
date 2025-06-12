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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('serie')->nullable();
            $table->foreignId('proveedores_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('recepciones_id')->constrained()->onDelete('cascade');
            $table->string('estado', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('tipo', ['MOTOR_ELECTRICO', 'MAQUINA_SOLDADORA', 'GENERADOR_DINAMO', 'OTROS']);
            $table->string('marca', 50)->nullable();
            $table->string('modelo', 50)->nullable();
            $table->string('color', 30)->nullable();
            $table->string('voltaje', 20)->nullable();
            $table->string('cable_positivo', 50)->nullable();
            $table->string('cable_negativo', 50)->nullable();
            $table->string('rpm', 20)->nullable();
            $table->string('potencia', 20)->nullable();
            $table->text('partes_faltantes')->nullable();
            $table->text('trabajo_realizar')->nullable();
            $table->decimal('costo_estimado', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
