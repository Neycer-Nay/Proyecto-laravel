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
        Schema::create('recepciones', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recepcion', 20)->unique();
            $table->date('fecha_recepcion');
            $table->time('hora_ingreso');
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->string('procedente', 100)->nullable();
            $table->decimal('presupuesto_inicial', 10, 2)->nullable();
            $table->boolean('registro_fotografico')->default(false);
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['recibido', 'en_reparacion', 'reparado', 'entregado', 'pendiente_retiro'])->default('recibido');
            $table->date('fecha_limite_retiro')->nullable();
            $table->boolean('entregado_con_boleta')->default(false);
            $table->string('nombre_receptor_entrega')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recepciones');
    }
};
