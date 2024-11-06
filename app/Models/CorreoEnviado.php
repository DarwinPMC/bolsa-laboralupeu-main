<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorreoEnviado extends Model
{
    use HasFactory;
    protected $table = 'correos_enviados';


    protected $fillable = ['destinatario', 'fecha_envio', 'estado', 'leido'];
}

