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
        Schema::create('restaurante_pendiente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('ubicacion_pendiente_id');
            $table->string('direccion');
            $table->string('telefono')->nullable();
            $table->string('email')->unique();
            $table->string('web')->nullable();
            $table->decimal('precio', 8, 2);
            $table->integer('soles')->default(0);
            $table->decimal('valoracion_promedio', 3, 2)->default(0);
            $table->boolean('patrocinados')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurante_pendiente');
    }
};
