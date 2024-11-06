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
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Usuario que postula
            $table->foreignId('oferta_id')->constrained()->onDelete('cascade'); // Oferta a la que se postula
            $table->string('cv')->nullable();
            $table->string('estado')->default('pendiente'); // Los valores pueden ser 'pendiente', 'aceptado', 'rechazado'

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulaciones');
    }
};
