<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'empresa',
        'ubicacion',
        'descripcion',
        'requisitos',
        'salario',
        'rubro_id',
        'user_id',
        'imagen',
        'dia_inicio',
        'dia_fin',
        'hora_inicio',
        'hora_fin',
        'fecha_inicio',
        'oferta_disponible_hasta',
        'visible',
        'limite_postulantes',



    ];
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'oferta_disponible_hasta' => 'datetime',
    ];
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
        $table->timestamps();
    });
}
public function user()
{
    return $this->belongsTo(User::class);
}
public function rubro()
{
    return $this->belongsTo(Rubro::class);
}
    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class);
    }
    public function contarPostulantes()
    {
        return $this->postulaciones()->count();
    }

}
