<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;
    protected $table = 'postulaciones';

    protected $fillable = ['user_id', 'oferta_id','cv'];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el modelo Oferta
    public function oferta()
    {
        return $this->belongsTo(Oferta::class, 'oferta_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
