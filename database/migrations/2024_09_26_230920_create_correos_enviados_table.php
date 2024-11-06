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
        Schema::create('correos_enviados', function (Blueprint $table) {
            $table->id();
            $table->string('destinatario'); // Correo del destinatario
            $table->timestamp('fecha_envio')->useCurrent(); // Fecha de envío
            $table->string('estado')->default('Enviado'); // Estado del correo
            $table->boolean('leido')->default(false); // Estado si el correo fue leído o no
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correos_enviados');
    }
};
