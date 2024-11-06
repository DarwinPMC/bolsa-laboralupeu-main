<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    // Relación uno a muchos con ofertas
    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }
}
