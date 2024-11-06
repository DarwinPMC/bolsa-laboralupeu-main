<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('empresa');
            $table->string('ubicacion');
            $table->text('descripcion');
            $table->text('requisitos')->nullable();
            $table->string('salario')->nullable();
            $table->foreignId('rubro_id')->nullable()->constrained('rubros')->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('imagen')->nullable();
            $table->string('dia_inicio')->nullable();
            $table->string('dia_fin')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('oferta_disponible_hasta')->nullable();
            $table->boolean('visible')->default(false);
            $table->unsignedInteger('limite_postulantes')->nullable();

            $table->timestamps();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
