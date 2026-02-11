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
        Schema::create('ubicaciones_restaurante_pendiente', function (Blueprint $table) {
            $table->id();
            $table->string('comunidad_autonoma');
            $table->string('provincia');
            $table->string('ciudad');
            $table->string('codigo_postal')->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            $table->timestamps();
        });

        Schema::table('restaurante_pendiente', function (Blueprint $table) {
            $table->foreign('ubicacion_pendiente_id')
                ->references('id')
                ->on('ubicaciones_restaurante_pendiente')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurante_pendiente', function (Blueprint $table) {
            $table->dropForeign(['ubicacion_pendiente_id']);
        });

        Schema::dropIfExists('ubicaciones_restaurante_pendiente');
    }
};
