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
        Schema::create('tipo_comida_restaurante_pendiente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurante_pendiente_id');
            $table->foreignId('tipo_comida_id')->constrained('tipo_comida')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['restaurante_pendiente_id', 'tipo_comida_id'], 'uq_tcrp_rest_tipo');

            $table->foreign('restaurante_pendiente_id', 'fk_tcrp_rest_pend')
                ->references('id')
                ->on('restaurante_pendiente')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_comida_restaurante_pendiente');
    }
};
