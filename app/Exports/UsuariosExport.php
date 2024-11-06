<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsuariosExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $tipoReporte = $this->request->input('tipo_reporte');
        $fechaInicio = $this->request->input('fecha_inicio');
        $fechaFin = $this->request->input('fecha_fin');

        if ($tipoReporte === 'postulantes') {
            return User::where('rol', 'postulante')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->get(['name', 'email', 'created_at']);
        } elseif ($tipoReporte === 'empresas') {
            return User::where('rol', 'empresa')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->get(['name', 'ruc', 'email', 'created_at']);
        }

        return collect();
    }

    public function headings(): array
    {
        if ($this->request->input('tipo_reporte') === 'postulantes') {
            return ['Nombre', 'Correo Electrónico', 'Fecha de Registro'];
        } else {
            return ['Nombre de Empresa', 'RUC', 'Correo Electrónico', 'Fecha de Registro', 'Avatar URL']; // Añade la columna Avatar URL
        }
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['argb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '1F4E78'],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => '1F4E78'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FFFFFF'],
                        ],
                    ],
                ]);

                $sheet->getStyle('A2:E' . $sheet->getHighestRow())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                foreach (range('A', 'E') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $sheet->getStyle('A1:E' . $sheet->getHighestRow())
                    ->getAlignment()->setWrapText(true);
            },
        ];
    }
}
