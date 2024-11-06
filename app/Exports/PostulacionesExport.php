<?php

namespace App\Exports;

use App\Models\Postulacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostulacionesExport implements FromCollection, WithHeadings
{
    protected $ofertaId;

    public function __construct($ofertaId)
    {
        $this->ofertaId = $ofertaId;
    }

    public function collection()
    {
        return Postulacion::with('user')
            ->where('oferta_id', $this->ofertaId)
            ->get()
            ->map(function ($postulacion) {
                return [
                    $postulacion->user->name,
                    $postulacion->user->email,
                    $postulacion->created_at->format('d-m-Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nombre del Postulante',
            'Correo Electrónico',
            'Fecha de Postulación',
        ];
    }
}
