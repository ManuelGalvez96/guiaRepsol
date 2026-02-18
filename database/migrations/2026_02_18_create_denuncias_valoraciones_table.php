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
        Schema::create('denuncias_valoraciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('valoracion_id')->constrained('valoraciones')->onDelete('cascade');
            $table->text('razon');
            $table->enum('estado', ['pendiente', 'revisado', 'rechazado'])->default('pendiente');
            $table->timestamps();
            
            // Constraint: un usuario solo puede denunciar una vez el mismo comentario
            $table->unique(['user_id', 'valoracion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias_valoraciones');
    }
};
